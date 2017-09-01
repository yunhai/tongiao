<?php

/**
 * Paginator Component
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller.Component
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Hash', 'Utility');

/**
 * This component is used to handle automatic model data pagination.  The primary way to use this
 * component is to call the paginate() method. There is a convenience wrapper on Controller as well.
 *
 * ### Configuring pagination
 *
 * You configure pagination using the PaginatorComponent::$settings.  This allows you to configure
 * the default pagination behavior in general or for a specific model. General settings are used when there
 * are no specific model configuration, or the model you are paginating does not have specific settings.
 *
 * {{{
 * 	$this->Paginator->settings = array(
 * 		'limit' => 20,
 * 		'maxLimit' => 100
 * 	);
 * }}}
 *
 * The above settings will be used to paginate any model.  You can configure model specific settings by
 * keying the settings with the model name.
 *
 * {{{
 * 	$this->Paginator->settings = array(
 * 		'Post' => array(
 * 			'limit' => 20,
 * 			'maxLimit' => 100
 * 		),
 * 		'Comment' => array( ... )
 * 	);
 * }}}
 *
 * This would allow you to have different pagination settings for `Comment` and `Post` models.
 *
 * @package       Cake.Controller.Component
 * @link http://book.cakephp.org/2.0/en/core-libraries/components/pagination.html
 */
App::import('Component', 'Paginator');

class CustomPaginatorComponent extends PaginatorComponent {

    /**
     * Handles automatic pagination of model records.
     *
     * @param Model|string $object Model to paginate (e.g: model instance, or 'Model', or 'Model.InnerModel')
     * @param string|array $scope Additional find conditions to use while paginating
     * @param array $whitelist List of allowed fields for ordering.  This allows you to prevent ordering
     *   on non-indexed, or undesirable columns.
     * @return array Model query results
     * @throws MissingModelException
     */
    public function paginate($object = null, $scope = array(), $whitelist = array()) {
        if (is_array($object)) {
            $whitelist = $scope;
            $scope = $object;
            $object = null;
        }
        $object = $this->_getObject($object);

        if (!is_object($object)) {
            throw new MissingModelException($object);
        }
        $options = $this->mergeOptions($object->alias);
        $options = $this->validateSort($object, $options, $whitelist);
        $options = $this->checkLimit($options);

        $conditions = $fields = $order = $limit = $page = $recursive = null;

        if (!isset($options['conditions'])) {
            $options['conditions'] = array();
        }

        $type = 'all';

        if (isset($options[0])) {
            $type = $options[0];
            unset($options[0]);
        }

        extract($options);

        if (is_array($scope) && !empty($scope)) {
            $conditions = array_merge($conditions, $scope);
        } elseif (is_string($scope)) {
            $conditions = array($conditions, $scope);
        }
        if ($recursive === null) {
            $recursive = $object->recursive;
        }

        $extra = array_diff_key($options, compact(
                        'conditions', 'fields', 'order', 'limit', 'page', 'recursive'
        ));
        if ($type !== 'all') {
            $extra['type'] = $type;
        }

        if (intval($page) < 1) {
            $page = 1;
        }
        $page = $options['page'] = (int) $page;

        if ($object->hasMethod('paginate')) {
            $results = $object->paginate(
                    $conditions, $fields, $order, $limit, $page, $recursive, $extra
            );
        } else {
            $parameters = compact('conditions', 'fields', 'order', 'limit', 'page');
            if ($recursive != $object->recursive) {
                $parameters['recursive'] = $recursive;
            }
            $results = $object->find($type, array_merge($parameters, $extra));
        }
        $defaults = $this->getDefaults($object->alias);
        unset($defaults[0]);

        if ($object->hasMethod('paginateCount')) {
            $count = $object->paginateCount($conditions, $recursive, $extra);
        } else {
            $parameters = compact('conditions');
            if ($recursive != $object->recursive) {
                $parameters['recursive'] = $recursive;
            }
            $count = $object->find('count', array_merge($parameters, $extra));
        }
        $pageCount = intval(ceil($count / $limit));
        if ($page > $pageCount) {
            $page = $pageCount;
            if ($object->hasMethod('paginate')) {
                $results = $object->paginate(
                        $conditions, $fields, $order, $limit, $page, $recursive, $extra
                );
            } else {
                $parameters = compact('conditions', 'fields', 'order', 'limit', 'page');
                if ($recursive != $object->recursive) {
                    $parameters['recursive'] = $recursive;
                }
                $results = $object->find($type, array_merge($parameters, $extra));
            }
        }
        $page = max(min($page, $pageCount), 1);
        $paging = array(
            'page' => $page,
            'current' => count($results),
            'count' => $count,
            'prevPage' => ($page > 1),
            'nextPage' => ($count > ($page * $limit)),
            'pageCount' => $pageCount,
            'order' => $order,
            'limit' => $limit,
            'options' => Hash::diff($options, $defaults),
            'paramType' => $options['paramType']
        );
        if (!isset($this->Controller->request['paging'])) {
            $this->Controller->request['paging'] = array();
        }
        $this->Controller->request['paging'] = array_merge(
                (array) $this->Controller->request['paging'], array($object->alias => $paging)
        );

        if (
                !in_array('Paginator', $this->Controller->helpers) &&
                !array_key_exists('Paginator', $this->Controller->helpers)
        ) {
            $this->Controller->helpers[] = 'Paginator';
        }
        return $results;
    }

}