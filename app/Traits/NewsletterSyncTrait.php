<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\Customer;
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
                    if ($newsletter = Newsletter::email($this->email)->first()) {
                        ++$newsletter->attempted;
                        $newsletter->save();
                    }
                    else {
                        $this->newsletter()->save(new Newsletter([
                            'email' => $this->email,
                            'attempted' => 1
                        ]));
                    }
                }
                break;
            }

            case 'updated' :
            {
                if ($this->newsletter_subscribed) {
                    if ($newsletter = Newsletter::email($this->email)->first()) {
                        ++$newsletter->attempted;
                        $newsletter->save();
                    }
                    else {
                        $this->newsletter()->save(new Newsletter([
                            'email' => $this->email,
                            'attempted' => 1
                        ]));
                    }
                }
                else {
                    //TODO unsubscribe customer from newsletter list
                }

                break;
            }
        }
    }
}
