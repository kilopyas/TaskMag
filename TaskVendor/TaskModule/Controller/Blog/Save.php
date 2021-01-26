<?php
namespace TaskVendor\TaskModule\Controller\Blog;

use Magento\Framework\Filesystem;
use Magento\Framework\Image\AdapterFactory;
use TaskVendor\TaskModule\Model\PostFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\MediaStorage\Model\File\UploaderFactory;

class Save extends \Magento\Framework\App\Action\Action
{
	protected $_postFactory;
    protected $_pageFactory;
    protected $uploaderFactory;
    protected $adapterFactory;
    protected $filesystem;

	public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, PostFactory $postFactory, UploaderFactory $uploaderFactory, AdapterFactory $adapterFactory, Filesystem $filesystem)
	{
		$this->_postFactory = $postFactory;
        $this->_pageFactory = $pageFactory;
        $this->uploaderFactory = $uploaderFactory;
        $this->adapterFactory = $adapterFactory;
        $this->filesystem = $filesystem;
		return parent::__construct($context);
	}

	public function execute()
	{
        $requests = $this->getRequest()->getParams();
        if(!isset($requests['id']))
            $post = $this->_postFactory->create();
        else
            $post = $this->_postFactory->create()->load($requests['id']);

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            try{
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'image']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png', 'webp']);
                $imageAdapter = $this->adapterFactory->create();
                $uploaderFactory->addValidateCallback('custom_image_upload',$imageAdapter,'validateUploadFile');
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('taskvendor/taskmodule');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                $imagePath = 'taskvendor/taskmodule'.$result['file'];
                $data['image'] = $imagePath;
                $post->setFeaturedImage($imagePath);
                
            } catch (\Exception $e) {}

        }

        $post->setName($requests['name']);
        $post->setUrlKey($requests['url']);
        $post->setPostContent($requests['content']);
        $post->setTags($requests['tags']);

        if($post->save())
            $this->messageManager->addSuccessMessage(__('Data was successfully saved.'));
        else
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        
        // return _redirect('post/post/index');
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('post/blog/index');
        return $resultRedirect;
	}
}