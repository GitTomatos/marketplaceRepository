<?php

declare(strict_types=1);

namespace App\Infrastructure\ValueObject;

final class TemplateManagerConfigs
{

    /**
     * Путь до директории с шаблонами
     */
    private string $templatesDirectoryPath;


    /**
     * @param string $templatesDirectoryPath - Путь до директории с шаблонами
     *
     * @throws \Exception
     */
    public function __construct(
        string $templatesDirectoryPath,
    ) {
        if (!is_dir($templatesDirectoryPath)) {
            throw new \Exception();
        }

        $this->templatesDirectoryPath = $templatesDirectoryPath;
    }


    /**
     * Создание объекта из массива
     *
     * @param array $arrayConfigs - настройки движка
     *
     * @throws \Exception
     */
    public static function createFromArray(array $arrayConfigs): self
    {
        self::validateArrayParams($arrayConfigs);
        $templatesDirectoryPath = $arrayConfigs['templatesDirectoryPath'];

        return new self(
            templatesDirectoryPath: $templatesDirectoryPath,
        );
    }

    /**
     * Проверка того, что указаны обязательны параметры движка
     *
     * @param array $arrayConfigs - настройки движка
     *
     * @throws \Exception
     */
    private static function validateArrayParams(array $arrayConfigs): void
    {
//templatesDirectoryPath
        if (!isset($arrayConfigs['templatesDirectoryPath'])) {
            throw new \Exception('В настройках движка не указан путь до директории с шаблонами');
        }

        $templatesDirectoryPath = $arrayConfigs['templatesDirectoryPath'];
        if (!is_dir($templatesDirectoryPath)) {
            throw new \Exception("'$templatesDirectoryPath' - Такой директории с шаблонами не существует.");
        }
    }

    public function getTemplatesDirectoryPath(): string
    {
        return $this->templatesDirectoryPath;
    }
}