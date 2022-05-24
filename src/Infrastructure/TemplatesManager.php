<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Infrastructure\ValueObject\TemplateManagerConfigs;
use Exception;

final class TemplatesManager
{
    /**
     * Настройки темлпейтера
     */
    private TemplateManagerConfigs $engineConfigs;

    /**
     * @param string $engineConfigFilePath - путь до файла с настройками движка
     *
     * @throws Exception
     */
    public function __construct(string $engineConfigFilePath)
    {
        $this->setEngineConfigs($engineConfigFilePath);
    }

    /**
     * Читаем из конфигурационного файла все доступные модули для вывода
     *
     * @param string $engineConfigFilePath - путь до файла с настройками
     *
     * @throws Exception
     */
    private function setEngineConfigs(string $engineConfigFilePath): self
    {
        $this->validateEngineConfigFilePath($engineConfigFilePath);

        $engineConfigsArray = require $engineConfigFilePath;
        $this->engineConfigs = TemplateManagerConfigs::createFromArray($engineConfigsArray);

        return $this;
    }

    /**
     * Проверить корректность пути до файла с настройками
     *
     * @param string $engineConfigFilePath - путь до файла с настройками
     *
     * @throws Exception
     */
    private function validateEngineConfigFilePath(string $engineConfigFilePath): void
    {
        if (!is_file($engineConfigFilePath)) {
            throw new Exception("'$engineConfigFilePath' - такого файла с настройками не существует.");
        }
    }

    /**
     * Получить полный путь до папки с доступными шаблонами
     */
    public function getFullPathToTemplates(): string
    {
        return $this->engineConfigs->getTemplatesDirectoryPath();
    }

    /**
     * Формируем список модулей и их шаблонов.
     * Модуль - это папка от конкретного поставщика с шаблонами
     */
    public function getModulesTemplatesList(): array
    {
        $fullTemplatesPath = $this->getFullPathToTemplates();
        $templatesDirArray = [];
        $eCommerceTypes = array_diff(scandir($fullTemplatesPath), ['..', '.']);

        foreach ($eCommerceTypes as $eCommerceTypeName) {
            $eCommerceTypeModulePath = "$fullTemplatesPath/$eCommerceTypeName";
            if (!is_dir($eCommerceTypeModulePath)) {
                continue;
            }

            $eCommerceTypeModules = array_diff(scandir($eCommerceTypeModulePath), ['..', '.', 'assets']);

            foreach ($eCommerceTypeModules as $moduleName) {
                $modulePath = "$eCommerceTypeModulePath/$moduleName";
                if (!is_dir($modulePath)) {
                    continue;
                }

                $moduleTemplates = array_diff(scandir($modulePath), ['..', '.', 'assets']);

                foreach ($moduleTemplates as $templateName) {
                    $templatePath = "$modulePath/$templateName";
                    if (!is_dir($templatePath)) {
                        continue;
                    }

                    $templatesDirArray[$eCommerceTypeName][$moduleName][] = $templateName;
                }
            }
        }

        return $templatesDirArray;
    }
}