<?php

namespace OpenSRS\fastlookup;

use OpenSRS\fastlookup\FastDomainLookup;
/**
 * @group fastlookup
 * @group fastlookup\FastDomainLookup
 */
class FastDomainLookupTest extends \PHPUnit_Framework_TestCase
{
    protected $validSubmission = array(
        'data' => array(
            'domain' => '',
            'selected' => '',
            'alldomains' => '',
            ),
        );

    /**
     * Valid submission should complete with no
     * exception thrown
     *
     * @return void
     *
     * @group validsubmission
     */
    public function testValidSubmission() {
        $data = json_decode( json_encode ($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->selected = ".com,.net";
        $data->data->alldomains = ".com,.net,.org";

        $ns = new FastDomainLookup( 'array', $data );

        $this->assertTrue( $ns instanceof FastDomainLookup );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing domain' => array('domain'),
            'missing selected' => array('selected'),
            'missing alldomains' => array('alldomains'),
            );
    }

    /**
     * Invalid submission should throw an exception
     *
     * @return void
     *
     * @dataProvider submissionFields
     * @group invalidsubmission
     */
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'data', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->data->domain = "phptest" . time() . ".com";
        $data->data->selected = ".com,.net";
        $data->data->alldomains = ".com,.net,.org";

        if(is_null($message)){
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$field.*not defined/"
              );
        }
        else {
          $this->setExpectedExceptionRegExp(
              'OpenSRS\Exception',
              "/$message/"
              );
        }



        // clear field being tested
        if(is_null($parent)){
            unset( $data->$field );
        }
        else{
            unset( $data->$parent->$field );
        }

        $ns = new FastDomainLookup( 'array', $data );
    }
}
