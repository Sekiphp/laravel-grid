<?php

use Boduch\Grid\Grid;

class GridTest extends GridBuilderTestCase
{
    public function testAddColumn()
    {
        $grid = new Grid($this->gridHelper);
        $grid->addColumn('name', [
            'title' => 'First name'
        ]);
        $grid->addColumn('sex', [
            'title' => 'Sex',
            'sortable' => true
        ]);

        $this->assertInstanceOf(\Boduch\Grid\Column::class, $grid->getColumns()['name']);
        $this->assertEquals('First name', $grid->getColumns()['name']->getTitle());

        $this->assertInstanceOf(\Boduch\Grid\Column::class, $grid->getColumns()['sex']);
        $this->assertEquals('Sex', $grid->getColumns()['sex']->getTitle());
        $this->assertTrue($grid->getColumns()['sex']->isSortable());
    }

    public function testAddColumnWithDecorators()
    {
        $grid = new Grid($this->gridHelper);
        $grid->addColumn('name', [
            'title' => 'First name',
            'clickable' => function () {
                return '';
            },
            'decorators' => [
                new \Boduch\Grid\Decorators\Url()
            ]
        ]);

        $column = $grid->getColumns()['name'];

        $this->assertEquals(2, count($column->getDecorators()));
        $this->assertInstanceOf(\Boduch\Grid\Decorators\DecoratorInterface::class, $column->getDecorators()[0]);
        $this->assertInstanceOf(\Boduch\Grid\Decorators\DecoratorInterface::class, $column->getDecorators()[1]);
    }

    public function testRenderColumnWithDecorator()
    {
        $grid = $this->getSampleGrid();
        $rows = $grid->getRows();

        $this->assertInstanceOf(\Boduch\Grid\Rows::class, $rows);
        $this->assertInstanceOf(\Boduch\Grid\Row::class, $rows[0]);

        $this->assertEquals("<a href=\"http://4programmers.net\">\nhttp://4programmers.net\n</a>\n", (string) $rows[0]->getValue('website'));
        $this->assertEquals("<a href=\"http://4programmers.net\">1</a>", (string) $rows[0]->getValue('id'));
    }

    public function testBuildGridWithEachCallbackAndModifyColumnValue()
    {
        $grid = $this->getSampleGrid();
        $grid->each(function (\Boduch\Grid\Row $row) {
            $row->get('website')->setValue('');
        });

        $rows = $grid->getRows();

        $this->assertEquals('', (string) $rows[0]->getValue('website'));
    }

    public function testBuildGridAndAddRowClass()
    {
        $grid = $this->getSampleGrid();
        $grid->each(function (\Boduch\Grid\Row $row) {
            $row->class = 'foo';
        });

        $rows = $grid->getRows();

        $this->assertEquals('foo', (string) $rows[0]->class);
    }

    private function getSampleGrid()
    {
        $grid = new Grid($this->gridHelper);
        $grid->addColumn('website', [
            'title' => 'Website',
            'decorators' => [
                new \Boduch\Grid\Decorators\Url()
            ]
        ]);
        $grid->addColumn('id', [
            'title' => 'ID',
            'clickable' => function ($row) {
                return '<a href="http://4programmers.net">' . $row['id'] . '</a>';
            }
        ]);

        $collection = collect([
            ['id' => 1, 'website' => 'http://4programmers.net']
        ]);

        $source = new \Boduch\Grid\Source\CollectionSource($collection);
        $grid->setSource($source);

        return $grid;
    }
}
