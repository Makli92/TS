<?php

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         version="4.2.0",
 *         title="TS API",
 *         @SWG\License(name="Makli's License")
 *     ),
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 * 
 *     @SWG\Definition(definition="Brands",
 *         type="array",
 *         @SWG\Items(ref="#/definitions/Brand")
 *     ),
 * 
 * 	   @SWG\Definition(definition="Stores",
 *         type="array",
 *         @SWG\Items(ref="#/definitions/Store")
 *     ),
 * 
 *     @SWG\Definition(definition="WorkOrders",
 *         type="array",
 *         @SWG\Items(ref="#/definitions/WorkOrder")
 *     ),
 * 
 *     @SWG\Definition(definition="MobilePhoneModels",
 *         type="array",
 *         @SWG\Items(ref="#/definitions/MobilePhoneModel")
 *     ),
 * 
 *     @SWG\Definition(definition="Users",
 *         type="array",
 *         @SWG\Items(ref="#/definitions/User")
 *     )
 * 
 * )
 */