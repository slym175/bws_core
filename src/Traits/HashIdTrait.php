<?php

namespace Bws\Core\Traits;

use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Vinkla\Hashids\Facades\Hashids;

trait HashIdTrait
{
    /**
     * Hashes the value of a field (e.g., ID)
     *
     * Will be used by the Eloquent Models (since it's used as trait there).
     *
     * @param null $field The field of the model to be hashed
     * @return  mixed
     */
    public function getHashedKey($field = null): mixed
    {
        // if no key is set, use the default key name (i.e., id)
        if ($field === null) {
            $field = $this->getKeyName();
        }

        // hash the ID only if hash-id enabled in the config
        if (config('core.hash-id')) {
            // we need to get the VALUE for this KEY (model field)
            $value = $this->getAttribute($field);

            return $this->encoder($value);
        }

        return $this->getAttribute($field);
    }

    public function encoder($id): string
    {
        return Hashids::encode($id);
    }

    public function decodeArray(array $ids): array
    {
        $result = [];
        foreach ($ids as $id) {
            $result[] = $this->decode($id);
        }

        return $result;
    }

    public function decode($id)
    {
        // check if passed as null, (could be an optional decodable variable)
        if (is_null($id) || strtolower($id) == 'null') {
            return $id;
        }

        // do the decoding if the ID looks like a hashed one
        return empty($this->decoder($id)) ? [] : $this->decoder($id)[0];
    }

    private function decoder($id): array
    {
        return Hashids::decode($id);
    }

    public function encode($id): string
    {
        return $this->encoder($id);
    }

    /**
     * Search the IDs to be decoded in the request data
     *
     * @param $requestData
     * @param $key
     *
     * @return  mixed
     * @throws Exception
     */
    private function locateAndDecodeIds($requestData, $key): mixed
    {
        // split the key based on the "."
        $fields = explode('.', $key);
        // loop through all elements of the key.
        return $this->processField($requestData, $fields, $key);
    }

    /**
     * Recursive function to process (decode) the request data with a given key
     * @param $data
     * @param $keysTodo
     * @param $currentFieldName
     * @return mixed
     * @throws Exception
     */
    private function processField($data, $keysTodo, $currentFieldName): mixed
    {
        // check if there are no more fields to be processed
        if (empty($keysTodo)) {
            // there are no more keys left - so basically we need to decode this entry
            if ($this->skipHashIdDecode($data)) {
                return $data;
            } else {
                $decodedField = $this->decode($data);

                if (empty($decodedField)) {
                    throw new \Exception('ID (' . $currentFieldName . ') is incorrect, consider using the hashed ID.');
                }

                return $decodedField;
            }
        }

        // take the first element from the field
        $field = array_shift($keysTodo);

        // is the current field an array?! we need to process it like crazy
        if ($field == '*') {
            //make sure field value is an array
            $data = is_array($data) ? $data : [$data];

            // process each field of the array (and go down one level!)
            $fields = $data;
            foreach ($fields as $key => $value) {
                $data[$key] = $this->processField($value, $keysTodo, $currentFieldName . '[' . $key . ']');
            }
            return $data;

        }

        // check if the key we are looking for does, in fact, really exist
        if (!array_key_exists($field, $data)) {
            return $data;
        }

        // go down one level
        $value = $data[$field];
        $data[$field] = $this->processField($value, $keysTodo, $field);

        return $data;
    }

    public function skipHashIdDecode($field): bool
    {
        return empty($field);
    }
}
