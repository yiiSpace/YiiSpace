in  Laravel5
=================

```
    
    public function rules() {
        $rules = [
        'billing_address' => 'required',
        ];
         if ($request->has('shipping_address_different') {
              $rules['shipping_address'] = 'required';
         }
         return $rules;
    }

```