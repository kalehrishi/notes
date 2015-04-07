<?php
namespace Notes\Collection;

use Notes\Model\Note as NoteModel;

class NoteCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldBeAddedMultipleObjects()
    {
        $resulset = array(
            '0' => array(
                'id' => 10,
                'userId' => 1,
                'title' => 'SQL',
                'body' => 'Standard language for accessing databases.',
                'createdOn' => '2015-03-26 11:36:44',
                'isDeleted' => 0
            ),
            '1' => array(
                'id' => 11,
                'userId' => 1,
                'title' => 'JQuery',
                'body' => 'Simplifies JavaScript programming.',
                'createdOn' => '2015-03-26 11:36:44',
                'isDeleted' => 0
            )
        );
        
        
        $noteCollection = new NoteCollection($resulset);
        $noteCollection->rewind();
        while ($noteCollection->hasNext()) {
            $this->assertEquals(10, $noteCollection->getRow(0)->getId());
            $this->assertEquals(1, $noteCollection->getRow(0)->getUserId());
            $this->assertEquals('SQL', $noteCollection->getRow(0)->getTitle());
            $this->assertEquals('Standard language for accessing databases.', $noteCollection->getRow(0)->getBody());
            $this->assertEquals(0, $noteCollection->getRow(0)->getIsDeleted());

            $this->assertEquals(11, $noteCollection->getRow(1)->getId());
            $this->assertEquals(1, $noteCollection->getRow(1)->getUserId());
            $this->assertEquals('JQuery', $noteCollection->getRow(1)->getTitle());
            $this->assertEquals('Simplifies JavaScript programming.', $noteCollection->getRow(1)->getBody());
            $this->assertEquals(0, $noteCollection->getRow(1)->getIsDeleted());
            $noteCollection->next();
        }
    }
}
