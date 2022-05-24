<?php

declare(strict_types=1);

namespace App\Module\b2b\style1\Table\Form\Type;

use App\Module\b2b\style1\Table\Domain\Entity\Package;
use App\Module\b2b\style1\Table\Domain\Entity\Purchase;
use App\Module\b2b\style1\Table\Infrastructure\Repository\PurchaseRepository;
use App\Module\b2b\style1\Table\Validator\PackageNameConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PackageCreationType extends AbstractType
{
    public function __construct(
        private PurchaseRepository $purchaseRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $purchaseChoicesEA = $this->getEAPurchaseChoices();

        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Название',
                    'constraints' => [
                        new PackageNameConstraint(),
                    ],
                ]
            )
            ->add(
                'info',
                TextareaType::class,
                [
                    'label' => 'Информация о пакете',
                ]
            )
            ->add(
                'price',
                IntegerType::class,
                [
                    'label' => 'Цена продажи',
                ]
            )
            ->add(
                'purchaseId',
                ChoiceType::class,
                [
                    'choices' => $purchaseChoicesEA,
                    'label' => 'Закупка',
                    'choice_value' => 'id',
                    'choice_label' => function (?Purchase $purchase) {
                        return $purchase ? $purchase->getName() : '';
                    },
                ],
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    'label' => 'Отправить',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Package::class,
        ]);
    }

    public function getEAPurchaseChoices(): array
    {
        return $this->purchaseRepository->findActiveEAPurchases();
    }
}