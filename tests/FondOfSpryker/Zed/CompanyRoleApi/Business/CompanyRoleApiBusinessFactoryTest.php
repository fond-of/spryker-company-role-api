<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CompanyRoleApi\Business\Model\CompanyRoleApi;
use FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiConfig;
use FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiDependencyProvider;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainer;
use Spryker\Zed\Kernel\Container;

class CompanyRoleApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Business\CompanyRoleApiBusinessFactory
     */
    protected $companyRoleApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiConfig
     */
    protected $companyRoleApiConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainer
     */
    protected $queryContainerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyRoleApiConfigMock = $this->getMockBuilder(CompanyRoleApiConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(CompanyRoleApiQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleApiBusinessFactory = new CompanyRoleApiBusinessFactory();

        $this->companyRoleApiBusinessFactory->setConfig($this->companyRoleApiConfigMock);
        $this->companyRoleApiBusinessFactory->setQueryContainer($this->queryContainerMock);
        $this->companyRoleApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateCompanyRoleApi(): void
    {
        $apiQueryContainerMock = $this->getMockBuilder(CompanyRoleApiToApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiQueryBuilderQueryContainerMock = $this->getMockBuilder(CompanyRoleApiToApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiToCompanyFacadeMock = $this->getMockBuilder(CompanyRoleApiToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API],
                [CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [CompanyRoleApiDependencyProvider::FACADE_COMPANY_ROLE]
            )->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API],
                [CompanyRoleApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [CompanyRoleApiDependencyProvider::FACADE_COMPANY_ROLE]
            )
            ->willReturnOnConsecutiveCalls(
                $apiQueryContainerMock,
                $apiQueryBuilderQueryContainerMock,
                $apiToCompanyFacadeMock
            );

        $companyRoleApi = $this->companyRoleApiBusinessFactory->createCompanyRoleApi();

        $this->assertInstanceOf(CompanyRoleApi::class, $companyRoleApi);
    }
}
