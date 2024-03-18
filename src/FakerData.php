<?php

namespace SicilianTestOrchestra;


use App\Http\Requests\UserPreferenceStoreRequest;
use SicilianTestOrchestra\SampleController;
use Faker\Factory as Faker;
use Tests\Tests\Controller\Request\RequestTest;

/**
 *
 */
class FakerData
{
    /**
     * @var \Faker\Generator
     */
    private \Faker\Generator $faker;

    private $data;

    /**
     *
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * @param $data
     * @return array
     */
    public function generateFakeData($data)
    {
        $fakeData = [];

        foreach ($data as $field => $rules) {
            $fakeData[$field] = $this->generateFieldData($rules);
        }

        return $fakeData;
    }

    /**
     * @param $rules
     * @return array|bool|int|string|void
     */
    protected function generateFieldData($rules)
    {
        foreach ($rules as $rule) {
            if (str_contains($rule, 'string')) {
                return $this->generateFakeWord($this->extractMin($rules), $this->extractMax($rules));
            }
            if (str_contains($rule, 'email')) {
                return $this->faker->email();
            }

            if (str_contains($rule, 'date')) {
                return $this->faker->date();
            }

            if (str_contains($rule, 'numeric')) {
                return $this->faker->numberBetween($this->extractMin($rules), $this->extractMax($rules));
            }

            // Handling boolean
            if (str_contains($rule, 'boolean')) {
                return $this->faker->boolean;
            }

            // Handling array
            if (str_contains($rule, 'array')) {
                return $this->faker->words; // Returns an array of words
            }

        }
    }

    /**
     * @param $minLength
     * @param $maxLength
     * @return string
     */
    function generateFakeWord($minLength, $maxLength)
    {
        do {
            $word = $this->faker->word;
        } while (strlen($word) < $minLength || strlen($word) > $maxLength);

        return $word;
    }

    /**
     * @param $rules
     * @return int
     */
    protected function extractMin($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'min:')) {
                return (int)substr($rule, 4);
            }
        }
        return 1; // Default minimum
    }

    /**
     * @param $rules
     * @return int
     */
    protected function extractMax($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'max:')) {
                return (int)substr($rule, 4);
            }
        }
        return 255; // Default maximum
    }

}
