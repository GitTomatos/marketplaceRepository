<?php

declare(strict_types=1);

namespace App\Module\b2b\style1\Table\Form\Type;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PackageRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProcessPackageType extends AbstractType
{
    public function __construct(private PackageRepository $packageRepository)
    {
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'electronicAuctionPackages',
            ChoiceType::class,
            [
                'choices' => $this->getElectronicAuctionChoices(),
                'label' => 'Пакеты Эл. аукциона',
                'choice_value' => 'id',
                'choice_label' => function(?Package $package) {
                    return $package ? $package->getName() : '';
                },
            ],
        )->add(
            'process',
            SubmitType::class,
            ['label' => 'Обработать пакет']
        );
    }

    public function getElectronicAuctionChoices(): array
    {
        return $this->packageRepository->findPackagesToProcessByType('electronicAuction');
    }
}