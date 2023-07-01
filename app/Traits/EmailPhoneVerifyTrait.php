<?php

namespace App\Traits;

trait EmailPhoneVerifyTrait
{
    public function syncVerifiedDate()
    {
            if ($this->email == null || strlen($this->email) < 5) {
                $this->email_verified_at = null;
            }

            if ($this->phone == null || strlen($this->phone) < 8) {
                $this->phone_verified_at = null;
            }

        $this->getDirty();

    }
}
