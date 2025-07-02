<?php

namespace Faker\Provider;

class HardwareLorem extends Lorem
{
    protected static $hardwareCategoryList = [
        'CPU', 'GPU', 'RAM', 'SSD', 'HDD', 'Motherboard', 'Graphics Card',
        'Power Supply Unit', 'Cooling Fan', 'Keyboard', 'Mouse', 'Monitor',
        'Headphones', 'Webcam', 'Microphone', 'Speaker', 'Soundcard', 'Joystick',
        'Gamepad', 'VR Headset', 'SSD Drive', 'HDD Drive', 'USB Flash Drive',
        'Network Card', 'Modem', 'Router', 'Switch'
    ];

    protected static $hardwareBrandList = [
        'Asus', 'Intel', 'AMD', 'NVIDIA', 'Samsung', 'Western Digital', 'Seagate',
        'Corsair', 'Gigabyte', 'ASRock', 'MSI', 'Logitech', 'Razer', 'Dell', 'HP',
        'Lenovo', 'Acer', 'LG', 'Apple', 'Microsoft', 'Google', 'Amazon', 'TP-Link',
        'D-Link', 'SteelSeries', 'HyperX', 'Cooler Master', 'NZXT', 'EVGA'
    ];

    protected static $hardwareProductList = [
        'Intel Core i7-10700K', 'AMD Ryzen 5 3600', 'NVIDIA GeForce RTX 3080',
        'Samsung 970 EVO Plus', 'Western Digital Blue 1TB', 'Seagate Barracuda 2TB',
        'Corsair Vengeance LPX 16GB', 'Gigabyte Z490 Aorus Master', 'ASRock B450M Pro4',
        'MSI B450 Gaming Plus', 'Logitech G Pro Wireless', 'Razer DeathAdder Elite',
        'Dell Alienware Aurora R10', 'HP Omen Obelisk', 'Lenovo Legion Tower 5',
        'Acer Predator Orion 3000', 'LG 27GL850-B', 'Apple MacBook Pro 16',
        'Microsoft Surface Pro 7', 'Google Pixelbook Go', 'Amazon Fire TV Stick',
        'TP-Link Archer C7 AC1750', 'D-Link DIR-868L', 'Belkin N600',
        'Steel', 'Series', 'HyperX Cloud II', 'Cooler Master MasterBox Q300L',
        'NZXT H510', 'EVGA GeForce RTX 3070 FTW3 ULTRA', 'Samsung 980 PRO 1TB',
        'Western Digital Black SN750 1TB', 'Seagate Barracuda 4TB',
        'Corsair Vengeance LPX 32GB', 'Gigabyte Z590 Aorus Pro', 'ASRock B550M Pro4',
        'MSI B550 Gaming Pro Carbon', 'Logitech G Pro X Superlight',
        'Razer DeathAdder V2', 'Dell Alienware Aurora R11', 'HP Omen Obelisk 2',
        'Lenovo Legion Tower 7', 'Acer Predator Orion 5000', 'LG 32GL850-B',
        'Apple MacBook Pro 13', 'Microsoft Surface Pro 8', 'Google Pixelbook Go 2',
        'Amazon Fire TV Stick 4K', 'TP-Link Archer C9 AC1900', 'D-Link DIR-869L',
        'Belkin N300', 'SteelSeries Arctis Pro Wireless', 'HyperX Cloud Alpha',
        'Cooler Master MasterBox NR200', 'NZXT H710', 'EVGA GeForce RTX 3060 Ti FTW3 ULTRA',
        'Samsung 990 PRO 1TB', 'Western Digital Black SN850 2TB',
        'Seagate Barracuda 6TB', 'Corsair Vengeance LPX 64GB', 'Gigabyte Z690 Aorus Master',
        'ASRock B650E Pro4', 'MSI B650 Gaming Edge', 'Logitech G Pro X Superlight 2',
        'Razer DeathAdder V3', 'Dell Alienware Aurora R12', 'HP Omen Obelisk 3',
        'Lenovo Legion Tower 9', 'Acer Predator Orion 7000', 'LG 34GL850-B',
        'Apple MacBook Pro 14', 'Microsoft Surface Pro 9', 'Google Pixelbook Go 3',
        'Amazon Fire TV Stick 4K Max', 'TP-Link Archer C1200', 'D-Link DIR-869L',
        'Belkin N600', 'SteelSeries Arctis Pro Wireless 2', 'HyperX Cloud Alpha S',
        'Cooler Master MasterBox NR400', 'NZXT H710i', 'EVGA GeForce RTX 3060 Ti FTW3 ULTRA'
    ];

    /**
     * @example 'CPU'
     * @return string
     */
    public static function hardwareCategory()
    {
        return static::randomElement(static::$hardwareCategoryList);
    }

    /**
     * Generate an array of random words
     *
     * @example array('Motherboard', 'CPU', 'Mouse')
     * @param  integer      $nb     how many words to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function hardwareCategories($nb = 3, $asText = false)
    {
       $categories = array();
        for ($i=0; $i < $nb; $i++) {
            $categories []= static::hardwareCategory();
        }

        return $asText ? implode(' ', $categories) : $categories;
    }

    /**
     * @example 'Intel Core i7-10700K'
     * @return string
     */
    public static function product()
    {
        return static::randomElement(static::$hardwareProductList);
    }

    /**
     * Generate an array of random products
     *
     * @example array('Intel Core i7-10700K', 'AMD Ryzen 5 3600', 'NVIDIA GeForce RTX 3080')
     * @param  integer      $nb     how many words to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function products($nb = 3, $asText = false)
    {
       $products = array();
        for ($i=0; $i < $nb; $i++) {
            $products []= static::product();
        }

        return $asText ? implode(' ', $products) : $products;
    }

    /**
     * @example 'Intel Core i7-10700K'
     * @return string
     */
    public static function brand()
    {
        return static::randomElement(static::$hardwareBrandList);
    }

    /**
     * Generate an array of random products
     *
     * @example array('Intel Core i7-10700K', 'AMD Ryzen 5 3600', 'NVIDIA GeForce RTX 3080')
     * @param  integer      $nb     how many words to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function brands($nb = 3, $asText = false)
    {
       $brands = array();
        for ($i=0; $i < $nb; $i++) {
            $brands []= static::brand();
        }

        return $asText ? implode(' ', $brands) : $brands;
    }
}
