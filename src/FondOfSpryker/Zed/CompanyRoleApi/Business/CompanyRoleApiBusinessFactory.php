<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Business;

use FondOfSpryker\Zed\CompanyRoleApi\Business\Model\CompanyRoleApi;
use FondOfSpryker\Zed\CompanyRoleApi\Business\Model\CompanyRoleApiInterface;
use FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiDependencyProvider;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface getQueryContainer()
 */
class CompanyRoleApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CompanyRoleApi\Business\Model\CompanyRoleApiInterface
     */
    public function createCompanyRoleApi(): CompanyRoleApiInterface
    {
        return new CompanyRoleApi(
            $this->getApiQueryContainer(),
            $this->getApiQueryBuilderQueryContainer(),
            $this->getQueryContainer(),
            $this->getCompanyRoleFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface
     */
    protected function getApiQueryContainer(): CompanyRoleApiToApiQueryContainerInterface
    {
        return $this->getProvidedDependency(CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface
     */
    protected function getApiQueryBuilderQueryContainer(): CompanyRoleApiToApiQueryBuilderQueryContainerInterface
    {
        return $this->getProvidedDependency(CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER);
    }

    /**
     * @return \FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyRoleApiToCompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyRoleApiDependencyProvider::FACADE_COMPANY_ROLE);
    }
}
