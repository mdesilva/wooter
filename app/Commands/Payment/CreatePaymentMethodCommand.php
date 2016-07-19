<?php

namespace Wooter\Commands\Payment;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\PaymentMethod;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Payment\PaymentMethodRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class CreatePaymentMethodCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $name
     */
    public function __construct($name, $user_id)
    {
        $this->name = $name;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     * @param PaymentMethodRepository $paymentMethodRepository
     * @param UserRepository $userRepository
     * @return PaymentMethod
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(PaymentMethodRepository $paymentMethodRepository, UserRepository $userRepository)
    {
        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        $paymentMethod = new PaymentMethod;
        $paymentMethod->name = $this->name;

        $paymentMethodRepository->create($paymentMethod);

        return $paymentMethod;
    }
}
