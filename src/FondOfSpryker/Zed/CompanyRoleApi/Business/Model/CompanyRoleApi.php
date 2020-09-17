<?php

namespace FondOfSpryker\Zed\CompanyRoleApi\Business\Model;

use FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface;
use FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiPaginationTransfer;
use Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer;
use Generated\Shared\Transfer\PropelQueryBuilderColumnTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Formatter\SimpleArrayFormatter;
use Propel\Runtime\Map\TableMap;
use Spryker\Zed\Api\ApiConfig;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyRoleApi implements CompanyRoleApiInterface
{
    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface
     */
    protected $apiQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface
     */
    protected $apiQueryBuilderQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface
     */
    protected $companyRoleApiQueryContainer;

    /**
     * @var \FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryContainerInterface $apiQueryContainer
     * @param \FondOfSpryker\Zed\CompanyRoleApi\Dependency\QueryContainer\CompanyRoleApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer
     * @param \FondOfSpryker\Zed\CompanyRoleApi\Persistence\CompanyRoleApiQueryContainerInterface $companyRoleApiQueryContainer
     * @param \FondOfSpryker\Zed\CompanyRoleApi\Dependency\Facade\CompanyRoleApiToCompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(
        CompanyRoleApiToApiQueryContainerInterface $apiQueryContainer,
        CompanyRoleApiToApiQueryBuilderQueryContainerInterface $apiQueryBuilderQueryContainer,
        CompanyRoleApiQueryContainerInterface $companyRoleApiQueryContainer,
        CompanyRoleApiToCompanyRoleFacadeInterface $companyRoleFacade
    ) {
        $this->apiQueryContainer = $apiQueryContainer;
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
        $this->companyRoleApiQueryContainer = $companyRoleApiQueryContainer;
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * @param int $idCompanyRole
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get(int $idCompanyRole): ApiItemTransfer
    {
        $companyRoleTransfer = (new CompanyRoleTransfer())->setIdCompanyRole($idCompanyRole);
        $companyRoleTransfer = $this->companyRoleFacade->getCompanyRoleById($companyRoleTransfer);

        if ($companyRoleTransfer->getIdCompanyRole() === null) {
            throw new EntityNotFoundException(sprintf('Company role not found for id %s', $idCompanyRole));
        }

        return $this->apiQueryContainer->createApiItem($companyRoleTransfer, $idCompanyRole);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $collection = [];
        $query = $this->buildQuery($apiRequestTransfer);
        $companyRoleIds = $query->select([SpyCompanyRoleTableMap::COL_ID_COMPANY_ROLE])
            ->setFormatter(new SimpleArrayFormatter())
            ->find()
            ->toArray();

        foreach ($companyRoleIds as $companyRoleId) {
            $collection[] = $this->get($companyRoleId)->getData();
        }

        $apiCollectionTransfer = $this->apiQueryContainer->createApiCollection($collection);
        $apiCollectionTransfer = $this->addPagination($query, $apiCollectionTransfer, $apiRequestTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    protected function buildQuery(ApiRequestTransfer $apiRequestTransfer): ModelCriteria
    {
        $apiQueryBuilderQueryTransfer = $this->buildApiQueryBuilderQuery($apiRequestTransfer);
        $query = $this->companyRoleApiQueryContainer->queryFind();
        $query = $this->apiQueryBuilderQueryContainer->buildQueryFromRequest($query, $apiQueryBuilderQueryTransfer);

        return $query;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiQueryBuilderQueryTransfer
     */
    protected function buildApiQueryBuilderQuery(ApiRequestTransfer $apiRequestTransfer): ApiQueryBuilderQueryTransfer
    {
        return (new ApiQueryBuilderQueryTransfer())
            ->setApiRequest($apiRequestTransfer)
            ->setColumnSelection($this->buildColumnSelection());
    }

    /**
     * @return \Generated\Shared\Transfer\PropelQueryBuilderColumnSelectionTransfer
     */
    protected function buildColumnSelection(): PropelQueryBuilderColumnSelectionTransfer
    {
        $columnSelectionTransfer = new PropelQueryBuilderColumnSelectionTransfer();
        $tableColumns = SpyCompanyRoleTableMap::getFieldNames(TableMap::TYPE_FIELDNAME);

        foreach ($tableColumns as $columnAlias) {
            $columnTransfer = (new PropelQueryBuilderColumnTransfer())
                ->setName(SpyCompanyRoleTableMap::TABLE_NAME . '.' . $columnAlias)
                ->setAlias($columnAlias);

            $columnSelectionTransfer->addTableColumn($columnTransfer);
        }

        return $columnSelectionTransfer;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Generated\Shared\Transfer\ApiCollectionTransfer $apiCollectionTransfer
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    protected function addPagination(
        ModelCriteria $query,
        ApiCollectionTransfer $apiCollectionTransfer,
        ApiRequestTransfer $apiRequestTransfer
    ): ApiCollectionTransfer {
        $query->setOffset(0)
            ->setLimit(-1);

        $total = $query->count();
        $page = $apiRequestTransfer->getFilter()->getLimit() ? ($apiRequestTransfer->getFilter()->getOffset() / $apiRequestTransfer->getFilter()->getLimit() + 1) : 1;
        $pageTotal = ($total && $apiRequestTransfer->getFilter()->getLimit()) ? (int)ceil($total / $apiRequestTransfer->getFilter()->getLimit()) : 1;

        if ($page > $pageTotal) {
            throw new NotFoundHttpException('Out of bounds.', null, ApiConfig::HTTP_CODE_NOT_FOUND);
        }

        $apiPaginationTransfer = (new ApiPaginationTransfer())
            ->setItemsPerPage($apiRequestTransfer->getFilter()->getLimit())
            ->setPage($page)
            ->setTotal($total)
            ->setPageTotal($pageTotal);

        $apiCollectionTransfer->setPagination($apiPaginationTransfer);

        return $apiCollectionTransfer;
    }
}
