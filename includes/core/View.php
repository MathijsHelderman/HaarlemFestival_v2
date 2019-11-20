<?php declare(strict_types=1);
  /**
   * Core View class
   */
  class View
  {
    protected $view_file;
    protected $view_data;

    /**
     * Meta tags like title, description and keywords for every view
     * are stored in a json-like php file and then loaded in the
     * constructor of this class in this parameter. If empty or not set,
     * standard meta tags will be the 0 index of the variable metas
     * from the metas file.
     * @var string[]
     */
    protected $metaTags;

    /**
     * Core view
     * @param string  $view_file  The path to the view
     * @param array   $view_data  All the data from the model(s), or for example from the end of the url
     * @param integer $metaNumber if common header is not used, the meta tags
     *                            should already exists, as backup it's
     *                            set to 0 anyways. For more info about the meta tags
     *                            check the description of the field. This is set
     *                            in the controller.
     */
    function __construct(string $view_file, array $view_data, int $metaNumber)
    {
      $this->view_file = $view_file;
      $this->view_data = $view_data;
      $this->metaTags = $this->setMetaTags($metaNumber);
    }

    private function setMetaTags($metaNumber) {
      // Get meta tags for this particular view
      $metas = include 'metas.inc.php';
      $this->metaTags = (isset($metas[$metaNumber]) &&
                        !empty($metas[$metaNumber])) ?
                        $metas[$metaNumber] : $metas[0];
    }

    /**
     * This method renders the view with a couple of customization options,
     *    and uses the constructor variable $view_file to attach the particular
     *    view to this core view from the directory VIEWS
     * @param  bool   $headerfooter first option: display common header and footer
     * @param  bool   $menu         second option: display common menu
     */
    // public function render(bool $headerfooter, bool $menu) {
    //   // Header
    //   if ($headerfooter) {
    //     $this->loadViewItem('common' . DS . 'header.php');
    //   }
    //
    //   // Menu
    //   if ($menu) {
    //     $this->loadViewItem('common' . DS . 'menu.php');
    //   }
    //
    //   // View file
    //   $this->loadViewItem($this->view_file);
    //
    //   // Footer
    //   if ($headerfooter) {
    //     $this->loadViewItem('common' . DS . 'footer.php');
    //   }
    // }

    /**
     * Safely load the view item from path VIEWS
     * @param  string $view_item path to the view item
     */
    private function loadViewItem(string $view_item) {
      try {
        if (
          (!@include_once(VIEWS . $view_item))
        ) { // @ - to suppress warnings,
          throw new Exception();
        }
        if (
          !file_exists(VIEWS . $view_item)
        ) {
          throw new Exception();
        }
        else {
          require_once(VIEWS . $view_item);
        }
      } catch(\Exception $e) {
        // echo "Couldn't load this: " . VIEWS . $view_item;
      }
    }
  }
?>
