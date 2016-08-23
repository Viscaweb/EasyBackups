<?php

namespace Helper;

use Models\File;

class DeepestCommonFolderHelper
{
    /**
     * @param File[] $files
     *
     * @return null|string
     */
    public function findDeepest($files)
    {
        $pathsPerDepth = [];

        foreach ($files as $file) {
            $folder = $this->findPath($file->getPath());
            foreach ($this->explodePath($folder) as $depth => $path) {
                if (!isset($pathsPerDepth[$depth][$path])) {
                    $pathsPerDepth[$depth][$path] = 0;
                }
                $pathsPerDepth[$depth][$path]++;
            }
        }

        krsort($pathsPerDepth);

        $totalFiles = count($files);
        foreach ($pathsPerDepth as $depth => $paths) {
            foreach ($paths as $path => $numberOfFilesWithThisPath) {
                if ($numberOfFilesWithThisPath === $totalFiles) {
                    return $path;
                }
            }
        }
    }

    /**
     * @param string $path
     *
     * @return string[]
     */
    private function explodePath($path)
    {
        $allPaths = [];

        $pathStructure = '';
        $depth = 0;
        foreach (explode('/', $path) as $part) {
            if (empty($part)) {
                continue;
            }
            $depth++;
            $pathStructure .= '/'.$part;
            $allPaths[$depth] = $pathStructure;
        }

        krsort($allPaths);

        return $allPaths;
    }

    /**
     * @param $file
     *
     * @return string
     */
    private function findPath($file)
    {
        return preg_replace('#^(.*)\/?[^\/]+$#U', '$1', $file);
    }
}
