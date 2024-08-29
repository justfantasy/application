<?php

namespace common\traits;

use Yii;

trait TreeTrait
{
    /**
     * @var string
     */
    protected $primaryKeyColumn = 'id';

    /**
     * @var string
     */
    protected $parentColumn = 'parent_id';

    /**
     * @var string
     */
    protected $titleColumn = 'name';

    /**
     * @var string
     */
    protected $weightColumn = 'weight';

    /**
     * 排序值
     * @var int
     */
    protected $weight = 0;


    /**
     * 生成树状结构
     * @param null $nodes
     * @return array
     */
    public function toTree($nodes = null): array
    {
        return $this->buildNestedArray($nodes);
    }

    /**
     * 需自己实现
     */
    public function allNodes()
    {
        return null;
    }

    /**
     * 需自己实现
     * @param $id
     * @param array $attributes
     * @return void
     */
    public function updateNode($id, array $attributes = [])
    {
    }

    protected function buildNestedArray($nodes = null, $parentId = 0): array
    {
        $branch = [];

        if (!$nodes) {
            $nodes = $this->allNodes();
        }

        foreach ($nodes as $node) {
            if ($node[$this->parentColumn] == $parentId) {
                $children = $this->buildNestedArray($nodes, $node[$this->primaryKeyColumn]);
                $node['children'] = $children ?: [];

                $branch[] = $node;
            }
        }

        return $branch;
    }

    /**
     * 更新所有节点
     * @param $nodes
     * @param int $parentId
     * @return void
     */
    public function updateNodes($nodes, int $parentId = 0)
    {
        // 前端是正序传递过来的，此处进行取反
        $nodes = array_reverse($nodes);
        foreach ($nodes as $node) {
            $this->updateNode($node['id'], [
                $this->weightColumn => $this->weight++,
                $this->parentColumn => $parentId
            ]);
            if (isset($node['children'])) {
                self::updateNodes($node['children'], $node['id']);
            }
        }
    }
}
