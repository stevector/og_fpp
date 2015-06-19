<?php

use Behat\Behat\Tester\Exception\PendingException;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawDrupalContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

  /**
   * @Then I load the available panes
   *
   * This method exists to test the loading of panes which would normally require
   * javascript. Instead of slowing down the overall test by relying on js
   * this method directly constructs the URL that AJAX would retrieve.
   */
  public function iLoadTheAvailablePanes()
  {
    $current_url = $this->getSession()->getCurrentUrl();
    $exploded_url = explode('/', $current_url);
    $nids = array_filter($exploded_url, 'is_numeric');
    $nid = array_pop($nids);
    $path = 'panels/ajax/editor/select-content/panelizer%3Anode%3A' . $nid . '%3Apage_manager/middle/fpp';
    $this->getSession()->visit($this->locatePath($path));
  }

  /**
   * @Then the available panes output contain :output
   *
   * This method exists because iLoadTheAvailablePanes does not get a normal
   * HTML document. Other text finding methods would fail.
   */
  public function theAvailablePanesOutputContain($output)
  {
    if (strpos((string) $this->getSession()->getPage()->getContent(), $this->fixStepArgument($output)) === FALSE) {
      throw new \Exception(sprintf("The last output did not contain '%s'.\nInstead, it was:\n\n%s'", $output, $this->getSession()->getPage()->getContent()));
    }
  }

  /**
   * @Then the available panes output does not contain :output
   */
  public function theAvailablePanesOutputDoesNotContain($output)
  {
    if (strpos((string) $this->getSession()->getPage()->getContent(), $this->fixStepArgument($output)) !== FALSE) {
      throw new \Exception(sprintf("The last output contained '%s'.\nInstead, it was:\n\n%s'", $output, $this->getSession()->getPage()->getContent()));
    }
  }

  /**
   * Returns fixed step argument (with \\" replaced back to ").
   *
   * @param string $argument
   *
   * @return string
   */
  protected function fixStepArgument($argument)
  {
    return str_replace('\\"', '"', $argument);
  }
}
