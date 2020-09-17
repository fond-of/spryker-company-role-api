<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Business\Model;

use Codeception\Test\Unit;
use Exception;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;

class CompanyRoleApiTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiDataTransfer
     */
    protected $apiDataTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiItemTransfer
     */
    protected $apiItemTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Business\Model\CompanyRoleApi
     */
    protected $companyRoleApi;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface
     */
    protected $apiQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface
     */
    protected $apiQueryBuilderQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface
     */
    protected $queryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacadeMock;

    /**
     * @var array
     */
    protected $transferData;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyResponseTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $companyRoleTransferMock;

    /**
     * @var int
     */
    protected $idCompanyRole;

    /**
     * @var $this
     */
    protected $companyTransfer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ApiRequestTransfer
     */
    protected $apiRequestTransferMock;

    /**
     * @var \ArrayObject
     */
    protected $responseMessages;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $responseMessageTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $iteratorMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->apiQueryContainerMock = $this->getMockBuilder(CompanyRoleApiToApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryBuilderQueryContainerMock = $this->getMockBuilder(CompanyRoleApiToApiQueryBuilderQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(CompanyRoleApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleFacadeMock = $this->getMockBuilder(CompanyRoleApiToCompanyRoleFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyRoleTransferMock = $this->getMockBuilder(CompanyRoleTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCompanyRole = 1;

        $this->companyRoleApi = new CompanyRoleApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->companyRoleFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $this->companyRoleFacadeMock->expects(self::atLeastOnce())
            ->method('getCompanyRoleById')
            ->with(self::isInstanceOf(CompanyRoleTransfer::class))
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn($this->idCompanyRole);

        $this->apiQueryContainerMock->expects(self::atLeastOnce())
            ->method('createApiItem')
            ->with($this->companyRoleTransferMock, $this->idCompanyRole)
            ->willReturn($this->apiItemTransferMock);

        self::assertEquals($this->apiItemTransferMock, $this->companyRoleApi->get($this->idCompanyRole));
    }

    /**
     * @return void
     */
    public function testGetWithEntityNotFoundException(): void
    {
        $this->companyRoleFacadeMock->expects(self::atLeastOnce())
            ->method('getCompanyRoleById')
            ->with(self::isInstanceOf(CompanyRoleTransfer::class))
            ->willReturn($this->companyRoleTransferMock);

        $this->companyRoleTransferMock->expects(self::atLeastOnce())
            ->method('getIdCompanyRole')
            ->willReturn(null);

        $this->apiQueryContainerMock->expects(self::never())
            ->method('createApiItem')
            ->with($this->companyRoleTransferMock, $this->idCompanyRole)
            ->willReturn($this->apiItemTransferMock);

        try {
            $this->companyRoleApi->get($this->idCompanyRole);
            self::fail();
        } catch (Exception $e) {
        }
    }
}
