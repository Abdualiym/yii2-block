<?php

namespace abdualiym\block\forms;

use abdualiym\block\entities\Block;
use abdualiym\block\entities\Category;
use abdualiym\block\entities\Text;
use elisdn\compositeForm\CompositeForm;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * @property integer $parent_id
 * @property string $label
 * @property string $slug
 * @property integer $data_type
 * @property string $data_helper
 * @property boolean $common
 * @property string $data_0
 * @property string $data_1
 * @property string $data_2
 * @property string $data_3
 */
class BlockForm extends Model
{
    public $parent_id;
    public $label;
    public $slug;
    public $data_type;
    public $common;

    private $_text;

    public function __construct(Block $block = null, $config = [])
    {
        if ($block) {
            $this->parent_id = $block->parent_id;
            $this->label = $block->label;
            $this->label = $block->label;
            $this->_text = $text;
        }

        parent::__construct($config);
    }



}