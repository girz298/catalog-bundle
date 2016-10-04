<?php
namespace CatalogBundle\DataFixtures\ORM;

use CatalogBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $electron = new Category();
        $electron->setTitle('Электроника');
        $electron->setStateFlag(true);
        $manager->persist($electron);

        $electron_children = [
            'Телефония и связь',
            'Планшеты, электронные книги',
            'Телевидение и видео',
            'Аудиотехника',
            'Фото- и видеотехника',
            'Аксессуары для телефонов',
            'Музыкальное оборудование',
            'Игровые приставки',
            'Минздрав предупреждает',
            'Гаджеты'
        ];

        foreach ($electron_children as $child_name) {
            $child = new Category();
            $child->setTitle($child_name);
            $child->setStateFlag(true);
            $child->setParent($electron);

            $child2 = new Category();
            $child2->setTitle($child_name . ' Test');
            $child2->setStateFlag(true);
            $child2->setParent($child);

            $manager->persist($child);
            $manager->persist($child2);
        }

        $computers = new Category();
        $computers->setTitle('Компьютеры и сети');
        $computers->setStateFlag(true);
        $manager->persist($computers);

        $computers_children = [
            'Ноутбуки',
            'Компьютеры и комплектующие',
            'Периферия',
            'Техника для печати и дизайна',
            'Сетевое оборудование',
            'Программное обеспечение'
        ];

        foreach ($computers_children as $child_name) {
            $child = new Category();
            $child->setTitle($child_name);
            $child->setStateFlag(true);
            $child->setParent($computers);
            $manager->persist($child);
        }

        $appliances = new Category();
        $appliances->setTitle('Бытовая техника');
        $appliances->setStateFlag(true);
        $manager->persist($appliances);

        $appliances_children = [
            'Крупногабаритная техника',
            'Встраиваемая техника',
            'Уборка, уход за одеждой, пошив',
            'Уход за волосами и телом',
            'Техника для здоровья',
            'Климатическая техника',
            'Подготовка и обработка продуктов',
            'Приготовление пищи',
            'Приготовление кофе и чая',
            'Прочее'
        ];

        foreach ($appliances_children as $child_name) {
            $child = new Category();
            $child->setTitle($child_name);
            $child->setStateFlag(true);
            $child->setParent($appliances);
            $manager->persist($child);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}