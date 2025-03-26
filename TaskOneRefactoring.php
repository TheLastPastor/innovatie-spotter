<?php
    class CompanyClass
    {
        /**
         * function to normalize company data into a single array
         * 
         * @param array $data company data that needs to be normalized.
         * 
         * @return void|array
         */
        public function normalizeCompanyData(array $data): ?array
        {
            $companyData = [];
            
            if (!$this->isCompanyDataValid($data)) {
                return null;
            }

            $companyData['address'] = trim($data['address']);
            
            if (empty($companyData['address'])) {
                $companyData['address'] = null;
            }

            $companyData['name'] = strtolower(trim($data['name']));

            $companyWebsite = $data['website'] ?? null;

            // check if company website begins with http or https and parse if true.
            if ($companyWebsite && preg_match('/(http|https)?:\/\//i', $companyWebsite)) {
                $companyData['website'] = parse_url($companyWebsite, PHP_URL_HOST);
            } else {
                $companyData['website'] = $companyWebsite;
            }

            return $companyData;
        }

        /**
         * Check if company data is valid by checking if array has address
         * 
         * @param array $data
         * 
         * @return bool
         */
        private function isCompanyDataValid(array $data): bool
        {
            return isset($data['address']);
        }
}

// Test Data
$input = [
    'name' => ' OpenAI ',
    'website' => 'https://openai.com ',
    'address' => ' '
];
$input2 = [
    'name' => 'Innovatiespotter',
    'address' => 'Groningen'
];
$input3 = [
    'name' => ' Apple ',
    'website' => '<HIDDEN INPUT> ',
];
$company = new CompanyClass();
$result = $company->normalizeCompanyData($input);
var_dump($result);
$result2 = $company->normalizeCompanyData($input2);
var_dump($result2);
$result3 = $company->normalizeCompanyData($input3);
var_dump($result3);