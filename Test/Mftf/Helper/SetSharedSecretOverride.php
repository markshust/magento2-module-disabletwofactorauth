<?php

declare(strict_types=1);

namespace RSilva\DisableTwoFactorAuth\Test\Mftf\Helper;

use Magento\FunctionalTestingFramework\DataGenerator\Handlers\CredentialStore;
use Magento\FunctionalTestingFramework\Exceptions\TestFrameworkException;
use Magento\FunctionalTestingFramework\Helper\Helper;
use Magento\FunctionalTestingFramework\Module\MagentoWebDriver;

class SetSharedSecretOverride extends Helper
{
    /**
     * Set the shared secret if appropriate
     *
     * @param string $username
     */
    /**
     * Set the shared secret if appropriate
     *
     * @param string $username
     */
    public function execute(string $username): void
    {
        /** @var MagentoWebDriver $webDriver */
        $webDriver       = $this->getModule('\\' . MagentoWebDriver::class);
        $credentialStore = CredentialStore::getInstance();
        if ($username !== getenv('MAGENTO_ADMIN_USERNAME')) {
            $sharedSecret = $credentialStore->decryptSecretValue(
                $credentialStore->getSecret('magento/tfa/OTP_SHARED_SECRET')
            );
            try {
                $webDriver->magentoCLI(
                    'security:tfa:google:set-secret ' . $username . ' ' . $sharedSecret
                );
            } catch (\Throwable $exception) {
                // Some tests intentionally use bad credentials.
            }
        }
    }
}
