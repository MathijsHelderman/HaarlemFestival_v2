<?php declare(strict_types=1);
  /**
   * This is a file containing all header meta tags like a title,
   * description and keywords. It is structured like a json file and has
   * the following index:
   *        0        => Default tags
   *        1        => Home page
   *        2        => Success page
   *        3        => Error page
   *        10-99    => login pages
   *        100-199  => Jazz pages
   *        200-299  => History pages
   *        300-399  => Dance pages
   *        400-499  => Food pages
   *        500-599  => Kids pages
   *        600-699  => Food pages
   *        700-799  => CMS pages
   * @return array of metatags for all pages
   */
  return [
      // Default tags
      0 => [
        'title'       => 'Haarlem Festival',
        'description' => 'Web application for Haarlem Festival',
        'keywords'    => 'Haarlem, Festival, webapplication'
      ],

      // Home tags
      1 => [
        'title'       => 'Home',
        'description' => 'Home page of the website.',
        'keywords'    => 'Home, Haarlem, Festival'
      ],

      // Success tags
      2 => [
        'title'       => 'Success',
        'description' => 'Something was a success.',
        'keywords'    => 'success'
      ],

      // Error tags
      3 => [
        'title'       => 'Error',
        'description' => 'Something went wrong.',
        'keywords'    => 'error'
      ],

      // Login pages 10-99
      10 => [
        'title'       => 'Logout',
        'description' => 'Logging out of Haarlem Festival.',
        'keywords'    => 'logout'
      ],
      11 => [
        'title'       => 'Forgotten Password',
        'description' => 'Page for requesting a new password.',
        'keywords'    => 'forgotten password'
      ],
      12 => [
        'title'       => 'Reset Password',
        'description' => 'Reset password page.',
        'keywords'    => 'new password'
      ],
      13 => [
        'title'       => 'Verify',
        'description' => 'Conformation page of a verified account.',
        'keywords'    => 'account, verified'
      ]
  ];
?>
