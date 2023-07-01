<?php

namespace App\Traits;

use App\Models\Newsletter;

trait NewsletterSyncTrait
{
    /**
     * @param string $action
     * @return void
     */
    public function syncNewsLetterSubscription(string $action = 'created'): void
    {
        switch ($action) {
            case 'created' :
            {
                if ($this->newsletter_subscribed) {
                    if (strlen($this->email) > 1) {
                        if ($newsletter = Newsletter::email($this->email)->first()) {
                            ++$newsletter->attempted;
                            $newsletter->save();
                        } else {
                            $this->newsletter()->save(new Newsletter([
                                'email' => $this->email,
                                'attempted' => 1
                            ]));
                        }
                    }
                }
                break;
            }

            case 'updated' :
            {
                if ($this->newsletter_subscribed) {
                    if (strlen($this->email) > 1) {
                        if ($newsletter = Newsletter::email($this->email)->first()) {
                            ++$newsletter->attempted;
                            $newsletter->save();
                        } else {
                            $this->newsletter()->save(new Newsletter([
                                'email' => $this->email,
                                'attempted' => 1
                            ]));
                        }

                    }
                    //TODO unsubscribe customer from newsletter list
                }

                break;
            }
        }
    }
}
