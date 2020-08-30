<?php

/**
 * @OA\RequestBody(
 *  request="ContactBody",
 *  required=true,
 *  @OA\JsonContent(
 *      type="object",
 *      required={"hostname", "recordType", "phone"},
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="nickname",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          type="string"
 *      )
 *  )
 * )
 */