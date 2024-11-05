<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Test\Mftf\Helper;

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
    public function execute(string $username): void
    {
        /** @var MagentoWebDriver $webDriver */
        $webDriver       = $this->getModule('\\' . MagentoWebDriver::class);
        $credentialStore = CredentialStore::getInstance();
        if ($username !== getenv('MAGENTO_ADMIN_USERNAME')) {
            $sharedSecret = $credentialStore->decryptSecretValue(
                (string) $credentialStore->getSecret('magento/tfa/OTP_SHARED_SECRET')
            );
            if (!$this->checkIfTwoFactorIsEnabled($webDriver)) {
                return;
            }
            try {
                $webDriver->magentoCLI(
                    'security:tfa:google:set-secret ' . $username . ' ' . $sharedSecret
                );
            } catch (\Throwable $exception) {
                // Some tests intentionally use bad credentials.
            }
        }
    }

    /**
     * @param MagentoWebDriver $webDriver
     */
    private function checkIfTwoFactorIsEnabled(MagentoWebDriver $webDriver): bool
    {
        try {
            return (bool)str_replace(PHP_EOL, '', $webDriver->magentoCLI('config:show twofactorauth/general/enable'));
        } catch (TestFrameworkException $exception) {

            return false;
        }

    }
}
