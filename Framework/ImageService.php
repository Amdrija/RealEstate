<?php

namespace Amdrija\RealEstate\Framework;

use Amdrija\RealEstate\Framework\Exceptions\FileNonExistentException;
use Amdrija\RealEstate\Framework\Exceptions\ImagePathNotPartOfDocumentRootException;

class ImageService extends FileService
{
    private const EXTENSION = ['image/jpeg' => '.jpg', 'image/png' => '.png'];
    private const DEFAULT_RELATIVE_IMAGE_SAVE_PATH = '/img';
    private const DEFAULT_ASSET_PATH = '/public';

    /**
     * Copies image temporary image file to the specified destination and renames it to the specified newName.
     * Returns the new image path.
     * @param array $image
     * @param string $destination
     * @param string $newName
     * @return string
     * @throws FileNonExistentException
     */
    public function moveTemporaryFile(array $image, string $destination, string $newName): string
    {
        $this->copy($image['tmp_name'], $destination);
        $this->rename($destination . '/' . basename($image['tmp_name']), $newName . $this->getImageExtension($image));

        return $destination . '/' . $newName . self::EXTENSION[$image['type']];
    }

    /**
     * Copies image temporary image file to the specified destination and renames it to the specified newName.
     * Returns the new image path.
     * @param array $images
     * @param string $destination
     * @param array $newNames
     * @throws FileNonExistentException
     */
    public function moveTemporaryFiles(array $images, string $destination, array $newNames)
    {
        foreach ($images['tmp_name'] as $index => $tmpImage) {
            $this->copy($tmpImage, $destination);
            $this->rename($destination . '/' . basename($tmpImage), $newNames[$index]);
        }
    }

    /**
     * Returns the relative path of the image from the DOCUMENT_ROOT.
     * If the image is not contained in the DOCUMENT_ROOT, throws ImagePathNotPartOfDocumentRootException.
     * @param $image
     * @return string
     * @throws ImagePathNotPartOfDocumentRootException
     */
    public function getRelativePathFromRoot($image): string
    {
        if (strpos($image, $_SERVER['DOCUMENT_ROOT'])) {
            throw new ImagePathNotPartOfDocumentRootException();
        }

        return substr($image, strlen($_SERVER['DOCUMENT_ROOT']));
    }

    /**
     * Returns the extension of the image base on the $image array.
     * @param array $image
     * @return string
     */
    public function getImageExtension(array $image): string
    {
        return self::EXTENSION[$image['type']];
    }

    /**
     * Returns the extension of the image base on the $image array.
     * @param array $image
     * @return array
     */
    public function getImageExtensions(array $image): array
    {
        return array_map(fn ($i) => self::EXTENSION[$i], $image['type']) ;
    }

    /**
     * Returns the path of where we save the image.
     * @return string
     */
    public function imageSaveDirectory(): string
    {
        return __DIR__ . '/..' . self::DEFAULT_ASSET_PATH .self::DEFAULT_RELATIVE_IMAGE_SAVE_PATH;
    }

    /**
     * @throws FileNonExistentException
     */
    public function deleteImage(string $image)
    {
        $this->delete(__DIR__ . '/..' . self::DEFAULT_ASSET_PATH . $image);
    }

    /**
     * Returns the relative path where the images was saved based on the name.
     * @param string $imageName
     * @return string
     */
    public function imageRelativePath(string $imageName): string
    {
        return self::DEFAULT_RELATIVE_IMAGE_SAVE_PATH . '/' . $imageName;
    }
}