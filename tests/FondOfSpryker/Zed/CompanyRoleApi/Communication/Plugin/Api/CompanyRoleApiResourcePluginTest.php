<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use Exception;
use FondOfSpryker\Zed\CompanyRoleApi\Business\CompanyRoleApiFacade;
use FondOfSpryker\Zed\CompanyRoleApi\CompanyRoleApiConfig;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

class CompanyRoleApiResourcePluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Communication\Plugin\Api\CompanyRoleApiResourcePlugin
     */
    protected $companyRoleApiResourcePlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Business\CompanyRoleApiFacade
     */
    protected $companyRoleApiFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected $apiItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected $apiCollectionTransferMock;

    /**
     * @var int
     */
    protected $idCompanyRole;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleApiFacadeMock = $this->getMockBuilder(CompanyRoleApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiRequestTransferMock = $this->getMockBuilder(ApiRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiCollectionTransferMock = $this->getMockBuilder(ApiCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyRole = 1;

        $this->companyRoleApiResourcePlugin = new CompanyRoleApiResourcePlugin();

        $this->companyRoleApiResourcePlugin->setFacade($this->companyRoleApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetResourceName(): void
    {
        self::assertEquals(
            CompanyRoleApiConfig::RESOURCE_COMPANY_ROLES,
            $this->companyRoleApiResourcePlugin->getResourceName()
        );
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        try {
            $this->companyRoleApiResourcePlugin->add($this->apiDataTransferMock);
            self::fail();
        } catch (Exception $exception) {
        }
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->companyRoleApiFacadeMock->expects(self::atLeastOnce())
            ->method('getCompanyRole')
            ->with($this->idCompanyRole)
            ->willReturn($this->apiItemTransferMock);

        self::assertEquals(
            $this->apiItemTransferMock,
            $this->companyRoleApiResourcePlugin->get($this->idCompanyRole)
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        try {
            $this->companyRoleApiResourcePlugin->update($this->idCompanyRole, $this->apiDataTransferMock);
            self::fail();
        } catch (Exception $exception) {
        }
    }

    /**
     * @return void
     */
    public function testRemove(): void
    {
        try {
            $this->companyRoleApiResourcePlugin->remove($this->idCompanyRole);
            self::fail();
        } catch (Exception $exception) {
        }
    }

    /**
     * @return void
     */
    public function testFind(): void
    {
        $this->companyRoleApiFacadeMock->expects(self::atLeastOnce())
            ->method('findCompanyRoles')
            ->with($this->apiRequestTransferMock)
            ->willReturn($this->apiCollectionTransferMock);

        self::assertEquals(
            $this->apiCollectionTransferMock,
            $this->companyRoleApiResourcePlugin->find($this->apiRequestTransferMock)
        );
    }
}
