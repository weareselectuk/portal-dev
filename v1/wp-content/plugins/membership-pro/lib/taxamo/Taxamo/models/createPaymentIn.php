<?php
/**
 *  Copyright 2014 Taxamo, Ltd.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

/**
 * $model.description$
 *
 * NOTE: This class is auto generated by the swagger code generator program. Do not edit the class manually.
 *
 */
class CreatePaymentIn {

  static $swaggerTypes = array(
      'amount' => 'number',
      'payment_timestamp' => 'string',
      'payment_information' => 'string'

    );

  /**
  * Amount that has been paid. Use negative value to register refunds.
  */
  public $amount; // number
  /**
  * When the payment was received in yyyy-MM-dd'T'HH:mm:ss(.SSS)'Z' format (24 hour, UTC timezone). Defaults to current date and time.
  */
  public $payment_timestamp; // string
  /**
  * Additional payment information.
  */
  public $payment_information; // string
  }
