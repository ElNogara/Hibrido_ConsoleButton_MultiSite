<?php
namespace Hibrido\Consolebutton\Block;

use Magento\Store\Model\StoreManagerInterface;
use Hibrido\Consolebutton\Model\ColorRepository;
use Magento\Framework\View\Element\Template;

/**
 * @package Hibrido\Consolebutton\Block
 */
class Color extends Template
{
    protected const TABLE_NAME = 'hibrido_button_color';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ColorRepository
     */
    protected $colorRepository;

    /**
     * @param StoreManagerInterface $storeManager O gerenciador de store do Magento.
     * @param ColorRepository $colorRepository O repositório de cores personalizado.
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ColorRepository $colorRepository
    ) {
        $this->storeManager = $storeManager;
        $this->colorRepository = $colorRepository;
    }

    /**
     * @return array Lista de store views.
     */
    public function getStoreViewsDB()
    {
        $result = $this->colorRepository->getAllStoreviews();
        $storeViews = [];

        foreach ($result as $row) {
            $storeViews[] = $row['storeview'];
        }

        return $storeViews;
    }

    /**
     * @param string $storeView A store view para a qual a cor do botão é desejada.
     * @return string A cor do botão em formato hexadecimal.
     */
    public function getButtonColor($storeView)
    {
        $result = $this->colorRepository->getAllColor();
        
        if (isset($result[$storeView]['color'])) {
            return $result[$storeView]['color'];
        }
    }

    /**
     * @return int O ID da store view atual.
     */
    public function getCurrentStoreId()
    {
        $currentStoreView = $this->storeManager->getStore()->getStoreId();
        return $currentStoreView;
    }
}
