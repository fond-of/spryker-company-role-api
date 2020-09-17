<?php

namespace FondOfSpryker\Zed\CompanyRoleApi;

use FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeBridge;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerBridge;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerBridge;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyRoleApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';
    public const PROPEL_QUERY_COMPANY_ROLE = 'PROPEL_QUERY_COMPANY_ROLE';
    public const QUERY_CONTAINER_API = 'QUERY_CONTAINER_API';
    public const QUERY_CONTAINER_API_QUERY_BUILDER = 'QUERY_CONTAINER_API_QUERY_BUILDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addCompanyRoleFacade($container);
        $container = $this->addApiQueryContainer($container);
        $container = $this->addApiQueryBuilderQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        $container = $this->addCompanyRolePropelQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_ROLE] = static function (Container $container) {
            return new CompanyRoleApiToCompanyRoleFacadeBridge($container->getLocator()->companyRole()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRolePropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_ROLE] = static function () {
            return SpyCompanyRoleQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiQueryContainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_API] = static function (Container $container) {
            return new CompanyRoleApiToApiQueryContainerBridge($container->getLocator()->api()->queryContainer());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addApiQueryBuilderQueryContainer(Container $container): Container
    {
        $container[static::QUERY_CONTAINER_API_QUERY_BUILDER] = static function (Container $container) {
            return new CompanyRoleApiToApiQueryBuilderQueryContainerBridge(
                $container->getLocator()->apiQueryBuilder()->queryContainer()
            );
        };

        return $container;
    }
}
