<?php


class ValidiationLogic
{
  CONST POSTCODE_NL_REGEX = "~\A[1-9]\d{3} ?[a-zA-Z]{2}\z~";
  CONST ADDRESS_OR_CITY_NL_REGEX = "/[a-zA-Z ]/m";
  CONST MOBILE_PHONENUMBER_NL_REGEX = "/^(((\\+31|0|0031)6){1}[1-9]{1}[0-9]{7})$/i";
  CONST HOUSE_PHONENUMBER_NL_REGEX = "/^(((0)[1-9]{2}[0-9][-]?[1-9][0-9]{5})|((\\+31|0|0031)[1-9][0-9][-]?[1-9][0-9]{6}))$/";

  public static function validateEmail($data)
  {
    if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
      return true;
    }

    return false;
  }

  public static function postalCode($data)
  {
    if (preg_match(self::POSTCODE_NL_REGEX, $data)) {
      return true;
    }

    return false;
  }

  public static function addressCityCheck($data)
  {
    if (preg_match(self::ADDRESS_OR_CITY_NL_REGEX, $data)) {
      return true;
    }

    return false;
  }

  public static function phoneNumber($data)
  {
    if (preg_match(self::MOBILE_PHONENUMBER_NL_REGEX, $data)) {
      return true;
    }

    if (preg_match(self::HOUSE_PHONENUMBER_NL_REGEX, $data)) {
      return true;
    }

    return false;
  }


}
