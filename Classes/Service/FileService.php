<?php

declare(strict_types=1);

namespace Igelb\IgAiforms\Service;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;

class FileService
{
    /**
     * Get file without metadata
     *
     * @param int $id
     * @return array
     */
    public static function getFile($id): array
    {
        $qb = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_metadata');

        $filePaths = $qb->select('file.identifier', 'file.extension as file_extension', 'file.uid AS file_uid', 'file.storage', 'metadata.uid AS metadata_uid', 'metadata.title', 'metadata.description', 'metadata.alternative')
            ->from('sys_file_metadata', 'metadata')
            ->innerJoin(
                'metadata',
                'sys_file',
                'file',
                $qb->expr()->eq('metadata.file', $qb->quoteIdentifier('file.uid'))
            )
            ->where(
                $qb->expr()->in('file.extension', ['"jpg"', '"jpeg"', '"png"', '"gif"', '"webp"']),
                $qb->expr()->eq('metadata.uid', $id),
            )
            ->executeQuery()
            ->fetchAssociative();

        if ($filePaths === false) {
            return [];
        }

        return $filePaths;
    }

    /**
     * Get file storage "fileadmin"
     *
     * @param int $id
     * @return string
     */
    public static function getFileStorage($id): string
    {
        $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
        $storage = $resourceFactory->getStorageObject($id);
        $storageConfiguration = $storage->getConfiguration();

        $storageString = $storageConfiguration['basePath'];

        // remove the last slash
        $storageString = rtrim($storageString, '/');

        return $storageString;
    }
}
