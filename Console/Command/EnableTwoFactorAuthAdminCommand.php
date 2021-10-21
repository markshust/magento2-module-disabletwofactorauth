<?php

namespace MarkShust\DisableTwoFactorAuth\Console\Command;

use Exception;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\User\Model\ResourceModel\User as AdminUser;
use Magento\User\Model\UserFactory;
use Magento\User\Model\User;
use Magento\User\Api\Data\UserInterface;
use MarkShust\DisableTwoFactorAuth\App\Data\ModifierUserInterface;

class EnableTwoFactorAuthAdminCommand extends Command
{
    public const ARGUMENT_ADMIN_USERNAME = 'username';
    public const ARGUMENT_ADMIN_USERNAME_DESCRIPTION = 'The admin username to disable 2FA';
    public const COMMAND_ADMIN_2FA_DISABLE = 'admin:user:2fa:enable';
    public const COMMAND_DESCRIPTION = 'Enable 2FA for admin';
    public const USER_ID = 'user_id';

    /**
     * @var AdminUser
     */
    private $adminUser;

    private $userFactory;

    /**
     * {@inheritdoc}
     *
     * @param AdminUser $userResource
     */
    public function __construct(
        AdminUser $adminUser,
        UserFactory $userFactory,
        $name = null
    ) {
        parent::__construct($name);
        $this->adminUser = $adminUser;
        $this->userFactory = $userFactory;
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_ADMIN_2FA_DISABLE);
        $this->setDescription(self::COMMAND_DESCRIPTION);
        $this->addArgument(
            self::ARGUMENT_ADMIN_USERNAME,
            InputArgument::REQUIRED,
            self::ARGUMENT_ADMIN_USERNAME_DESCRIPTION
        );
        $this->setHelp(
            <<<HELP
This command disable of 2FA an admin by its username.
To disable 2FA:
      <comment>%command.full_name% username</comment>
HELP
        );
        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $adminUserName = $input->getArgument(self::ARGUMENT_ADMIN_USERNAME);

        try {
            $user = $this->getAdminByUserName($adminUserName);
            $this->enable2FAForAdmin($user);
            $outputMessage = sprintf('2FA enabled for admin "%s"', $adminUserName);
        } catch (Exception $exception) {
            $outputMessage = $exception->getMessage();
        }

        $output->writeln('<info>' . $outputMessage . '</info>');
    }

    /**
     * @param string $adminUserName
     * @return User
     * @throws NoSuchEntityException
     */
    private function getAdminByUserName(string $adminUserName): User
    {
        $user = $this->userFactory->create();
        $user = $user->loadByUsername($adminUserName);
        if (!$user->getId()) {
            throw NoSuchEntityException::singleField('username', $adminUserName);
        }

        return $user;
    }

    /**
     * @param User $user
     * @return void
     * @throws Exception
     */
    private function enable2FAForAdmin(User $user): void
    {
        $user->setData(ModifierUserInterface::IS_ENABLE_2FA_AUTH, ModifierUserInterface::FIELD_2FA_ENABLE);
        $this->adminUser->save($user);
    }
}
