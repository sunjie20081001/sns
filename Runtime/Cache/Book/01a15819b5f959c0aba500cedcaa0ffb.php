<?php if (!defined('THINK_PATH')) exit();?><div class="content-top">
    <div class="top clearfix">
        <h1><?php echo ($book_section["title"]); ?></h1>
        <div class="copy-link">
            <a data-role="copy_book_link" book-link="<?php echo U('Book/Index/read',array('id'=>$book_id,'section_id'=>$section_id),true,true);?>"><i class="icon icon-copy"></i><?php echo L("_COPY_THIS_PAGE_LINK_");?></a>
        </div>
        <?php if($book_section['type']&&check_auth('Book/index/editSection')): ?><a class="pull-right" href="<?php echo U('Book/Index/editSection',array('section_id'=>$section_id));?>" style="margin-top: 15px;"><i class="icon-edit"></i><?php echo L("_EDIT_");?></a><?php endif; ?>
        
    </div>
    <div class="line"></div>
</div>
<div class="content-content">
    <div style="width: 100%;text-align: right"><i class="icon-eye-open"></i> <?php echo ($book_section["see"]); ?></div>
    <?php if(!empty($book_section["keywords"])): ?><div class="keywords">
          <?php echo L("_KEY_WORD_WITH_SPACE_"); echo ($book_section["keywords"]); ?>
        </div><?php endif; ?>
    <?php if(!empty($book_section["summary"])): ?><div class="summary">
            <blockquote>
                <p><?php echo L("_INTRODUCTION_WITH_COLON_"); echo ($book_section["summary"]); ?></p>
            </blockquote>
        </div><?php endif; ?>
    <?php if(!empty($book_section["content"])): ?><div class="content" style="margin-top: 15px;">
            <?php echo ($book_section["content"]); ?>
        </div><?php endif; ?>
</div>
<style>
    .zclip{
        top:24px!important;
    }
</style>
<script>
    $(function(){
        $('[data-role="copy_book_link"]').zclip({
            copy: function () {
                return $(this).attr('book-link');
            },
            afterCopy: function () {
                toast.success(<?php echo L('_COPY_SUCCESS_WITH_SINGLE_');?>);
            }
        });
    });
    $(function () {
        var interval=setInterval(function(){
            uParse('#book-content');
            clearInterval(interval);
        },100)

    })
</script>