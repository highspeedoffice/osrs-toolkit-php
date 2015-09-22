<?php

use OpenSRS\domains\lookup\GetDomainsByExpiry;
/**
 * @group lookup
 * @group GetDomainsByExpiry
 */
class GetDomainsByExpiryTest extends PHPUnit_Framework_TestCase
{
    protected $func = "lookupGetDomainsByExpiry";

    protected $validSubmission = array(
        'attributes' => array(
            'exp_from' => '',
            'exp_to' => '',
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

        $data->attributes->exp_from = strtotime("-1 week");
        $data->attributes->exp_to = time();

        $ns = new GetDomainsByExpiry( 'array', $data );

        $this->assertTrue( $ns instanceof GetDomainsByExpiry );
    }

    /**
     * Data Provider for Invalid Submission test
     */
    function submissionFields() {
        return array(
            'missing exp_from' => array('exp_from'),
            'missing exp_to' => array('exp_to'),
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
    public function testInvalidSubmissionFieldsMissing( $field, $parent = 'attributes', $message = null ) {
        $data = json_decode( json_encode($this->validSubmission) );

        $data->attributes->exp_from = strtotime("-1 week");
        $data->attributes->exp_to = time();

        $this->setExpectedException( 'OpenSRS\Exception' );

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

        $ns = new GetDomainsByExpiry( 'array', $data );
     }
}
