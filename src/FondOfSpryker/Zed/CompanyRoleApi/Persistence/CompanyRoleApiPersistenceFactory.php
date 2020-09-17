<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Persistence;

use FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiDependencyProvider;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiConfig getConfig()
 * @method \FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface getQueryContainer()
 */
class CompanyRoleApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(CompanyRoleApiDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }
}
