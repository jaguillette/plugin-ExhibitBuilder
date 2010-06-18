<?php

/**
 * Tests for set_exhibit_sections_for_loop_by_exhibit function
 */
class SetExhibitSectionsForLoopByExhibitTest extends ExhibitBuilder_TestCase 
{
	/**
	 * Tests whether set_exhibit_sections_for_loop_by_exhibit correctly sets exhibit sections on the view when the exhibit is specified.
	 */
	public function testSetExhibitsForLoopByExhibitWhenExhibitIsSpecified()
    {
		$exhibit = $this->_createNewExhibit(true, false, 'Exhibit Title', 'Exhibit Description', 'Exhibit Credits', 'exhibitslug');
        $this->assertTrue($exhibit->exists());

        $maxExhibitSectionCount = 8;        
        $exhibitSectionSlugs = array();
        for($i = 1; $i <= $maxExhibitSectionCount; $i++) {
            $exhibitSection = $this->_createNewExhibitSection($exhibit, 'Exhibit Section Title ' . $i, 'Exhibit Section Description ' . $i, 'exhibitsectionslug' . $i);
            $this->assertTrue($exhibitSection->exists());
            $exhibitSectionSlugs[] = $exhibitSection->slug;
        }
		
        set_exhibit_sections_for_loop_by_exhibit($exhibit);
        $exhibitSectionCount = 0;
        foreach ($this->view->exhibitSections as $exhibitSection) {
            $this->assertTrue(in_array($exhibitSection->slug, $exhibitSectionSlugs));
            $exhibitSectionCount++;
        }
        $this->assertEquals($maxExhibitSectionCount, $exhibitSectionCount);
    }
    
    /**
	 * Tests whether set_exhibit_sections_for_loop_by_exhibit correctly sets exhibit sections on the view when the exhibit is not specified.
	 */
	public function testSetExhibitsForLoopByExhibitWhenExhibitIsNotSpecified()
    {
		$exhibit = $this->_createNewExhibit(true, false, 'Exhibit Title', 'Exhibit Description', 'Exhibit Credits', 'exhibitslug');
        $this->assertTrue($exhibit->exists());

        $maxExhibitSectionCount = 8;        
        $exhibitSectionSlugs = array();
        for($i = 1; $i <= $maxExhibitSectionCount; $i++) {
            $exhibitSection = $this->_createNewExhibitSection($exhibit, 'Exhibit Section Title ' . $i, 'Exhibit Section Description ' . $i, 'exhibitsectionslug' . $i);
            $this->assertTrue($exhibitSection->exists());
            $exhibitSectionSlugs[] = $exhibitSection->slug;
        }
		
		exhibit_builder_set_current_exhibit($exhibit);
        
        // Make sure it uses the current exhibit by default
        set_exhibit_sections_for_loop_by_exhibit();
        $exhibitSectionCount = 0;
        foreach ($this->view->exhibitSections as $exhibitSection) {
            $this->assertTrue(in_array($exhibitSection->slug, $exhibitSectionSlugs));
            $exhibitSectionCount++;
        }
        $this->assertEquals($maxExhibitSectionCount, $exhibitSectionCount);
    }
}