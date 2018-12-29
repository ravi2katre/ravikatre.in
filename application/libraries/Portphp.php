<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 10/15/2017
 * Time: 7:34 PM
 */
use Port\Csv\CsvReader;
use Port\Doctrine\DoctrineWriter;
use Port\Steps\StepAggregator;
use Port\Steps\Step\ValueConverterStep;
use Port\ValueConverter\DateTimeValueConverter;
use Port\Reader\ArrayReader;


defined('BASEPATH') OR exit('No direct script access allowed');


class Portphp {

    protected $mFormCount = 0;

    public function __construct()
    {
        $CI =& get_instance();

        $CI->load->helper('form');
        $CI->load->library('form_validation');
        $CI->load->config('form_validation');

        // CI Bootstrap libraries
        $CI->load->library('system_message');
    }
    public function read_csv(){
        // Create and configure the reader
        $file = new \SplFileObject('input.csv');
        $csvReader = new CsvReader($file);

        // Tell the reader that the first row in the CSV file contains column headers
        $csvReader->setHeaderRowNumber(0);

        // Create the workflow from the reader
        $workflow = new StepAggregator($csvReader);



        // Process the workflow
        $workflow->process();
    }

    public function csv_export(){

        // Your input data
        $reader = new ArrayReader(array(
                array(
                    'first',        // This is for the CSV header
                    'last',
                    array(
                        'first' => 'james',
                        'last'  => 'Bond'
                    ),
                    array(
                        'first' => 'hugo',
                        'last'  => 'Drax'
                    )
                ))
        );

        // Create the workflow from the reader
        $workflow = new StepAggregator($reader);

        // Add the writer to the workflow
        $file = new \SplFileObject('output.csv', 'w');
        $writer = new CsvWriter($file);
        $workflow->addWriter($writer);

        // As you can see in the input data, the first names are not capitalized
        // correctly. Let's fix that with a value converter:
        $valueConverterStep = new ValueConverterStep();
        $valueConverterStep->add('first', function ($value) {
            return ucfirst($value);
        });
        $workflow->addStep($valueConverterStep);

        // Process the workflow
        $workflow->process();
    }
}