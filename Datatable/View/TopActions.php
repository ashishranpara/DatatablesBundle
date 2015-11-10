<?php

/**
 * This file is part of the SgDatatablesBundle package.
 *
 * (c) stwe <https://github.com/stwe/DatatablesBundle>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sg\DatatablesBundle\Datatable\View;

use Sg\DatatablesBundle\Datatable\Column\Action;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Container;
use Exception;

/**
 * Class TopActions
 *
 * @package Sg\DatatablesBundle\Datatable\View
 */
class TopActions
{
    /**
     * TopActions container.
     *
     * @var array
     */
    protected $topActions;

    /**
     * An OptionsResolver instance.
     *
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * Start HTML.
     *
     * @var string
     */
    protected $startHtml;

    /**
     * End HTML.
     *
     * @var string
     */
    protected $endHtml;

    /**
     * The actions container.
     *
     * @var array
     */
    protected $actions;

    //-------------------------------------------------
    // Ctor.
    //-------------------------------------------------

    /**
     * Ctor.
     */
    public function __construct()
    {
        $this->topActions = array();
        $this->resolver = new OptionsResolver();
        $this->configureOptions($this->resolver);
    }

    //-------------------------------------------------
    // Setup TopActions
    //-------------------------------------------------

    /**
     * Set TopActions.
     *
     * @param array $topActions
     *
     * @return $this
     */
    public function setTopActions(array $topActions)
    {
        $this->topActions = $this->resolver->resolve($topActions);
        $this->callingSettersWithOptions($this->topActions);

        return $this;
    }

    /**
     * Configure Options.
     *
     * @param OptionsResolver $resolver
     *
     * @return $this
     */
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array('actions'));

        $resolver->setDefaults(array(
            'start_html' => '',
            'end_html' => ''
        ));

        $resolver->setAllowedTypes('start_html', 'string');
        $resolver->setAllowedTypes('end_html', 'string');
        $resolver->setAllowedTypes('actions', 'array');

        return $this;
    }

    /**
     * Calling setters with options.
     *
     * @param array $options
     *
     * @return $this
     * @throws Exception
     */
    private function callingSettersWithOptions(array $options)
    {
        $methods = get_class_methods($this);

        foreach ($options as $key => $value) {
            $key = Container::camelize($key);
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            } else {
                throw new Exception('callingSettersWithOptions(): ' . $method . ' invalid method name');
            }
        }

        return $this;
    }

    //-------------------------------------------------
    // Getters && Setters
    //-------------------------------------------------

    /**
     * Set start HTML.
     *
     * @param string $startHtml
     *
     * @return $this
     */
    protected function setStartHtml($startHtml)
    {
        $this->startHtml = $startHtml;

        return $this;
    }

    /**
     * Get start HTML.
     *
     * @return string
     */
    public function getStartHtml()
    {
        return $this->startHtml;
    }

    /**
     * Set end HTML.
     *
     * @param string $endHtml
     *
     * @return $this
     */
    protected function setEndHtml($endHtml)
    {
        $this->endHtml = $endHtml;

        return $this;
    }

    /**
     * Get end HTML.
     *
     * @return string
     */
    public function getEndHtml()
    {
        return $this->endHtml;
    }

    /**
     * Set actions.
     *
     * @param array $actions
     *
     * @return $this
     */
    protected function setActions(array $actions)
    {
        foreach ($actions as $action) {
            $newAction = new Action();
            $this->actions[] = $newAction->setupOptionsResolver($action);
        }

        return $this;
    }

    /**
     * Get actions.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }
}
