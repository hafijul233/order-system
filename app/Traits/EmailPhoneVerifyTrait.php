<?php

namespace App\Traits;

trait EmailPhoneVerifyTrait
{
    public function syncVerifiedDate()
    {
        if (isset($this->email)) {
            if ($this->email == null || strlen($this->email) < 5) {
                $this->email_verified_at = null;
            }
        }

        if (isset($this->phone)) {
            if ($this->phone == null || strlen($this->phone) < 8) {
                $this->phone_verified_at = null;
            }
        }

        $this->getDirty();
    }
}
