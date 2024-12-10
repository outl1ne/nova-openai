<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Enums\OpenAIRequestMethod;
use Outl1ne\NovaOpenAI\Enums\OpenAIRequestStatus;

class OpenAIRequestSeeder extends Seeder
{
    public function run(): void
    {
        $listOfNames = ['Product Enrichment', 'Product attributes', 'Product keywords'];
        $total = 100;
        while ($total > 0) {
            $openAiRequest = new OpenAIRequest();
            $openAiRequest->method = OpenAIRequestMethod::CHAT;
            $openAiRequest->status = OpenAIRequestStatus::SUCCESS;
            $openAiRequest->cost = rand(1, 1000) / 1000;
            $openAiRequest->time_sec = rand(100, 5000) / 1000;
            $openAiRequest->model_requested = collect(['gpt-4', 'gpt-3.5-turbo', 'text-davinci-003'])->random();
            $openAiRequest->model_used = $openAiRequest->model_requested;
            $openAiRequest->input = json_decode('[{"role": "system", "content": "As an AI language model, your task is to determine attributes for products in specified categories\nbased on provided data. Follow the guidelines below to process the data and produce the desired output.\n\nYour goal is to comprehensively extract all relevant attributes from the product information,\nincluding but not limited to the predefined category attributes. This ensures a thorough capture\nof all attributes valuable for filtering.\n\n\nRules:\n\"bucket_value\" is a value that must later group together similar attribute values.\nIf the user provides \"bucketing_instructions\" for the specific attribute, you must use them.\nFor example, values \"Glossy Black\" and \"Matte Black\" must be grouped under \"Black\" with \"bucket_value\".\nIf the \"bucket_value\" is a count of something, always include what it counts: \"2 USB-C\" > \"2 USB-C ports\".\n\nExamples:\n\"Bluetooth 5.3\" > \"Bluetooth\"\n\"Wi-Fi 6. \" > \"WiFi\"\n\"2048GB\" > \"2 TB\"\n\"false\" > \"No\"\n\"true\" > \"Yes\"\n\"Must\" (Estonian for color) > \"Black\"\n\nIf any user provided attribute contains multiple distinct values\n(e.g., in product descriptions, attributes, or other raw data sources),\nsplit each distinct value into separate rows.\nHandle delimiters like slashes (\"/\"), commas (\",\"), and spaces,\nensuring values such as \"Black/Red\" or \"Leather, Metal\" are split into individual rows.\nThis allows better filtering on webstores, improving customer experience.\n\nThis rule applies across all attributes where it is suitable, such as, but not limited to:\n- Material (e.g., \"Plastic, Metal Mesh, Rubber\")\n- Color (e.g., \"Red & Black\")\n- Ports (e.g., \"2xUSB, HDMI\")\n- Ingredients (e.g., \"Water, Sugar, Flavoring\")\n\nEach distinct value must have its own `standardized_text_value` matching the `bucket_value`.\nFor example, \"Red & Black & Silver\" should be split into three seperate product_attributes.\n\nIf an attributes value is missing, do not infer or guess. Instead:\n- Leave the value blank or mark it as null.\n- Omit the attribute if no value is mentioned.\n- Use only values explicitly stated in the data; do not infer based on context.\n- Do not add extra separators for empty fields.\n\nExamples of attributes to exclude, but it not limited to:\n - Product descriptions or marketing content\n - Product names or titles\n - Price\n\nTranslation Requirement:\n- All attributes and their values must be translated to English if they are in a different language.\n- Mixed-language attribute values should be fully translated to English.\n- Ensure consistent use of English for attribute names and values across all products.\n"}, {"role": "user", "content": "Determine attributes for the product in the category \"Smartphones\" using the data provided below.\nYou must strictly adhere to all instructions and guidelines.\nDo not deviate from the specified formats and rules.\n\n\n\nProduct Data:\nProduct Name:\niphone 13 red 250gb\n\nProduct Description:\nMobilie telefoni\n\nProduct Attributes:\nname|value|unit\n\nComprehensive Extraction of Attributes:\nIdentify and extract all relevant attributes that can be determined from the product data.\nInclude any attribute relevant to the products features, specifications, or functionalities.\nBeyond the predefined list below, ensure you capture every attribute up to the maximum attribute limit if provided.\n\nPredefined Product Category Attributes:\nThe following attributes are already defined for the Smartphones category and\nmust be included in the product_attributes array.\nattribute_group|attribute_key|base_units|attribute_type|attribute_example_values|value_instructions|bucketing_instructions|description|filter_priority\nHardware|storage_capacity|N/A|number|N/A|N/A|N/A|N/A|10\nDisplay|display_size|N/A|number|N/A|N/A|N/A|N/A|9\nBattery|battery_life|N/A|number|N/A|N/A|N/A|N/A|8\nCamera|camera_resolution|N/A|number|N/A|N/A|N/A|N/A|7\nPerformance|processor_speed|N/A|number|N/A|N/A|N/A|N/A|6\nMemory|ram|N/A|number|N/A|N/A|N/A|N/A|5\nBattery|battery_capacity|N/A|number|N/A|N/A|N/A|N/A|4\nConnectivity|network_technology|N/A|string|N/A|N/A|N/A|N/A|3\nOperating System|operating_system|N/A|string|N/A|N/A|N/A|N/A|2\nPrice|price|N/A|number|N/A|N/A|N/A|N/A|1\nDesign|colour|N/A|N/A|N/A|N/A|N/A|N/A|11\nBrand|brand|N/A|N/A|N/A|N/A|N/A|N/A|12\n"}]');
            $openAiRequest->output = json_decode('[{"index": 0, "message": {"role": "assistant", "content": "{\"explanation\":\"Based on the provided product data and category attributes, the relevant attributes for the smartphone have been extracted. The product name iphone 13 red 250gb provides information about the brand, color, and storage capacity. The predefined attributes for the smartphone category guide the extraction process, ensuring that all relevant attributes are captured according to the instructions.\",\"is_successful\":true,\"data\":[{\"name\":\"Brand\",\"attribute_group\":\"Brand\",\"attribute_key\":\"brand\",\"original_value\":\"iphone\",\"bucket_value\":\"Apple\",\"standardized_text_value\":\"Apple\",\"standardized_numeric_value\":null,\"original_units\":null},{\"name\":\"Colour\",\"attribute_group\":\"Design\",\"attribute_key\":\"colour\",\"original_value\":\"red\",\"bucket_value\":\"Red\",\"standardized_text_value\":\"Red\",\"standardized_numeric_value\":null,\"original_units\":null},{\"name\":\"Storage Capacity\",\"attribute_group\":\"Hardware\",\"attribute_key\":\"storage_capacity\",\"original_value\":\"250gb\",\"bucket_value\":\"250 GB\",\"standardized_text_value\":\"250 GB\",\"standardized_numeric_value\":250,\"original_units\":\"GB\"}]}", "refusal": null}, "logprobs": null, "finish_reason": "stop"}]');
            $openAiRequest->arguments = json_encode(['temperature' => rand(0, 10) / 10, 'max_tokens' => rand(100, 2000)]);
            $openAiRequest->meta = json_encode(['user' => fake()->email(), 'session_id' => fake()->uuid()]);
            $openAiRequest->usage_prompt_tokens = rand(10, 500);
            $openAiRequest->usage_completion_tokens = rand(20, 1000);
            $openAiRequest->usage_total_tokens = $openAiRequest->usage_prompt_tokens + $openAiRequest->usage_completion_tokens;
            $openAiRequest->error = $openAiRequest->status === OpenAIRequestStatus::ERROR ? fake()->sentence() : null;
            $openAiRequest->created_at = fake()->dateTimeBetween('-1 month', 'now');
            $openAiRequest->updated_at = $openAiRequest->created_at;
            $openAiRequest->name = $listOfNames[rand(0, count($listOfNames) - 1)];
            $openAiRequest->save();
            $total--;
        }
    }
}
