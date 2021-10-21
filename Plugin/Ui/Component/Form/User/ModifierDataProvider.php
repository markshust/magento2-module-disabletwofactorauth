<?php

declare(strict_types=1);

namespace MarkShust\DisableTwoFactorAuth\Plugin\Ui\Component\Form\User;

use Magento\TwoFactorAuth\Ui\Component\Form\User\DataProvider;
use Magento\User\Model\ResourceModel\User\CollectionFactory as UserCollectionFactory;
use Magento\User\Model\User;
use MarkShust\DisableTwoFactorAuth\App\Data\ModifierUserInterface;

/**
 * Class ModifierDataProvider
 * @package MarkShust\DisableTwoFactorAuth\Plugin\Ui\Component\Form\User
 */
class ModifierDataProvider
{
    /**
     * @var UserCollectionFactory
     */
    private $userCollectionFactory;

    /**
     * @param UserCollectionFactory $userCollectionFactory
     */
    public function __construct(UserCollectionFactory $userCollectionFactory)
    {
        $this->userCollectionFactory = $userCollectionFactory;
    }

    /**
     * @param DataProvider $dataProvider
     * @param array $loadedData
     * @return array
     */
    public function afterGetData(DataProvider $dataProvider, array $loadedData): array
    {
        $users = $this->userCollectionFactory->create()->getItems();
        /** @var User $user */
        foreach ($users as $user) {
            $loadedData[(int)$user->getId()][ModifierUserInterface::IS_ENABLE_TWOFACTORAUTH] =
                $user->getData(ModifierUserInterface::IS_ENABLE_TWOFACTORAUTH);
        }

        return $loadedData;
    }
}
