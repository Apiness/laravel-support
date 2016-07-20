<?php namespace Apiness\Support\Testing;

use Swift_Message;
use Swift_Events_EventListener;
use Illuminate\Support\Arr;

/**
 * The TracksEmails trait allows to test emails by asserting that emails have been sent matching different criteria.
 *
 * @note To enable emails tracking, set the `MAIL_DRIVER` property to `log` in `phpunit.xml`.
 */
trait TracksEmails {

	protected $emails = [ ];

	/** @before */
	public function setUpTracksEmails()
	{
		// We use a Swift Mailer plugin to listen to emails that will be sent so we keep track of these
		// We need to register the caller as the delegate and implement the trackEmail() delegate method that will be called every time an email is sent

		$mailer = $this->app->make('mailer');
		$mailer->getSwiftMailer()->registerPlugin(new TracksEmailsEventListener($this));
	}

	public function trackEmail(Swift_Message $email)
	{
		$this->emails[] = $email;
	}

	/**
	 * Assert that at least one email has been sent.
	 *
	 * @return $this
	 */
	public function emailWasSent()
	{
		$this->assertNotEmpty($this->emails, 'No emails have been sent.');

		return $this;
	}

	/**
	 * Assert that no email has been sent.
	 *
	 * @return $this
	 */
	public function emailWasNotSent()
	{
		$this->assertEmpty($this->emails, 'Did not expect any emails to have been sent.');

		return $this;
	}

	/**
	 * Assert that a given number of emails has been sent.
	 *
	 * @param $count
	 *
	 * @return $this
	 */
	public function emailsSent($count)
	{
		$sent = count($this->emails);

		$this->assertCount($count, $this->emails, "Expected $count emails to have been sent, but $sent were.");

		return $this;
	}

	/**
	 * Assert that an email has been sent by the given sender.
	 *
	 * @param                    $sender
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailSentFrom($sender, Swift_Message $email = null)
	{
		$this->assertHasEmailWithKey($sender, $email, "No email was sent by $sender");

		return $this;
	}

	/**
	 * Assert that an email has been sent to the given recipient.
	 *
	 * @param                    $recipient
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailSentTo($recipient, Swift_Message $email = null)
	{
		$this->assertHasEmailWithKey($recipient, $email, "No email was sent to $recipient");

		return $this;
	}

	/**
	 * Assert that an email has been copied to the given recipient.
	 *
	 * @param                    $recipient
	 * @param                    $blind
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailCopiedTo($recipient, $blind = true, Swift_Message $email = null)
	{
		$email = $this->getEmail($email);

		$copied = $email->getCc();

		if ($blind && $bcc = $email->getBcc()) {
			$copied = array_merge($copied, $email->getBcc());
		}

		$this->assertArrayHasKey($recipient, $copied, "No email was copied to $recipient");

		return $this;
	}

	/**
	 * Assert that an email has the given subject.
	 *
	 * @param                    $subject
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailSubjectEquals($subject, Swift_Message $email = null)
	{
		$this->assertEquals($subject, $this->getEmail($email)->getSubject(), "No email with the provided subject was sent.");

		return $this;
	}

	/**
	 * Assert that an email has the given body.
	 *
	 * @param                    $body
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailBodyEquals($body, Swift_Message $email = null)
	{
		$this->assertEquals($body, $this->getEmail($email)->getBody(), "No email with the provided body was sent.");

		return $this;
	}

	/**
	 * Assert that an email contains the given body.
	 *
	 * @param                    $excerpt
	 * @param Swift_Message|null $email
	 *
	 * @return $this
	 */
	public function emailBodyContains($excerpt, Swift_Message $email = null)
	{
		$this->assertContains($excerpt, $this->getEmail($email)->getBody(), "No email containing the provided body excerpt was found.");

		return $this;
	}

	/**
	 * Asserts that at least one email has a specified key.
	 *
	 * @param                    $key
	 * @param Swift_Message|null $email
	 * @param string             $message
	 *
	 * @return $this
	 */
	public function assertHasEmailWithKey($key, Swift_Message $email = null, $message = '')
	{
		$this->emailWasSent();

		if ($email) {
			$this->assertArrayHasKey($key, $email->getTo(), $message);
		}
		else {
			$hasKey = false;

			foreach ($this->emails as $email) {
				if (Arr::exists($email->getTo(), $key)) {
					$hasKey = true;
				}
			}

			$this->assertTrue($hasKey);
		}

		return $this;
	}

	protected function getEmail(Swift_Message $email = null)
	{
		$this->emailWasSent();

		return $email ?: $this->lastEmail();
	}

	protected function lastEmail()
	{
		return end($this->emails);
	}

}

class TracksEmailsEventListener implements Swift_Events_EventListener {

	protected $delegate;

	public function __construct($delegate)
	{
		$this->delegate = $delegate;
	}

	public function beforeSendPerformed($event)
	{
		$this->delegate->trackEmail($event->getMessage());
	}

}
