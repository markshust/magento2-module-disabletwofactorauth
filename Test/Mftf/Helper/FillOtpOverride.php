<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Test\Mftf\Helper;

use Magento\FunctionalTestingFramework\Exceptions\TestFrameworkException;
use Magento\FunctionalTestingFramework\Helper\Helper;
use Magento\FunctionalTestingFramework\Module\MagentoWebDriver;

class FillOtpOverride extends Helper
{
    /**
     * Fill the OTP form if appropriate
     *
     * @param string $tfaAuthCodeSelector
     * @param string $confirmSelector
     * @param string $errorMessageSelector
     */
    public function execute(string $tfaAuthCodeSelector, string $confirmSelector, string $errorMessageSelector): void
    {
        /** @var MagentoWebDriver $webDriver */
        $webDriver = $this->getModule('\\' . MagentoWebDriver::class);
        if (!$this->checkIfTwoFactorIsEnabled($webDriver)) {
            return;
        }
        try {
            $webDriver->seeElementInDOM($errorMessageSelector);
            // Login failed so don't handle 2fa
        } catch (\Exception $e) {
            $otp = $webDriver->getOTP();
            $webDriver->waitForPageLoad();
            $webDriver->waitForElementVisible($tfaAuthCodeSelector);
            $webDriver->fillField($tfaAuthCodeSelector, $otp);
            $webDriver->click($confirmSelector);
            $webDriver->waitForPageLoad();
        }
    }

    /**
     * @param MagentoWebDriver $webDriver
     */
    private function checkIfTwoFactorIsEnabled(MagentoWebDriver $webDriver): bool
    {
        try {
            $cliResult = $webDriver->magentoCLI('config:show twofactorauth/general/enable');
            if ($cliResult === 'CLI did not return output.') {
                return false;
            }

            return (bool)str_replace(PHP_EOL, '', $cliResult);
        } catch (TestFrameworkException $exception) {

            return false;
        }

    }
}
