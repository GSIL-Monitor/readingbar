<?php 
	include 'routes/MessagesRoutes.php';
	/*后台-web*/
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		/*阅读计划*/
		Route::group(['prefix'=>'readplan'], function () {
			/*列表界面*/
			Route::get('/',['as'=>'admin.readplan.index','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@index']);
			/*编辑界面*/
			Route::get('/{plan_id}/detail',['as'=>'admin.readplan.form','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@readPlanForm']);
		});
		/*借阅服务*/
		Route::group(['prefix'=>'borrowService'], function () {
			/*列表界面*/
			Route::get('/',['as'=>'admin.readplan.index','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@borrowServiceList']);
			/*编辑界面*/
			Route::get('/{plan_id}/detail',['as'=>'admin.readplan.form','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@borrowServiceForm']);
		});
		/*推广*/
		Route::group(['prefix'=>'promotion'], function () {
			/*推广首页*/
			Route::get('/',['as'=>'admin.promotion.index','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@index']);
			/*推广相关信息*/
			Route::get('/{pid}/promotionInfo',['as'=>'admin.promotion.promotionInfo','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@promotionInfo']);
			/*下载关联会员数据*/
			Route::get('/{pcode}/download',['as'=>'admin.promotion.promotionInfo','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@downloadExcel']);
			/*推广编辑表单*/
			Route::get('/{pid}/promotionEdit',['as'=>'admin.promotion.promotionInfo','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@promotionEdit']);
			
			Route::group(['prefix'=>'type'], function () {
				/*公告列表*/
				Route::get('/',['as'=>'admin.TOPromotion.PromotionTypeList','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@PromotionTypeList']);
				/*公告表单*/
				Route::get('{id}/form',['as'=>'admin.TOPromotion.PromotionTypeForm','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@PromotionTypeForm']);
				Route::get('/form',['as'=>'admin.TOPromotion.PromotionTypeForm','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@PromotionTypeForm']);
				
			});
		});
		/*优惠券*/
		Route::group(['prefix'=>'discount'], function () {
			/*优惠券情况统计*/
			Route::get('/',['as'=>'admin.dicount.index','uses'=>'Readingbar\Back\Controllers\Discount\DiscountController@DiscountList']);
			/*优惠券类型管理*/
			Route::get('/type',['as'=>'admin.dicountType.index','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@DiscountTypeList']);
			/*优惠券类型表单*/
			Route::get('/type/form',['as'=>'admin.dicountType.DiscountTypeForm','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@DiscountTypeForm']);
			/*优惠券类型表单*/
			Route::get('/type/{pid}/form',['as'=>'admin.dicountType.DiscountTypeForm','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@DiscountTypeForm']);
				
		});
		/*后台用户收件箱*/
		Route::group(['prefix'=>'messagesBox'], function () {
			/*收件箱消息列表*/
			Route::get('/',['as'=>'admin.messagesBox.index','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@index']);
			/*收件箱消息详情*/
			Route::get('/{id}/detail',['as'=>'admin.messagesBox.messageDetail','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@messageDetail']);
		});
		/*网站设置*/
		Route::group(['prefix'=>'setting'], function () {
			/*设置列表*/
			Route::get('/',['as'=>'admin.setting.index','uses'=>'Readingbar\Back\Controllers\Setting\SettingController@settingList']);
		});
		/*后台礼品管理*/
		Route::group(['prefix'=>'gift'], function () {
			Route::group(['prefix'=>'cardBatch'], function () {
				/*礼品卡批次-列表*/
				Route::get('/',['as'=>'admin.cardBacth.cardBatchList','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@cardBatchList']);
				/*礼品卡批次-表单*/
				Route::get('/form',['as'=>'admin.cardBacth.cardBatchForm','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@cardBatchForm']);
				Route::get('/{id}/form',['as'=>'admin.cardBacth.cardBatchForm','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@cardBatchForm']);
			});
			Route::group(['prefix'=>'cards'], function () {
				/*礼品卡-列表*/
				Route::get('/',['as'=>'admin.cards.cardsList','uses'=>'Readingbar\Back\Controllers\Gift\CardsController@cardsList']);
			});
		});
		/*公告*/
		Route::group(['prefix'=>'notice'], function () {
			/*公告列表*/
			Route::get('/',['as'=>'admin.notice.noticeList','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@noticeList']);
			/*公告表单*/
			Route::get('/{id}/form',['as'=>'admin.notice.noticeForm','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@noticeForm']);
			Route::get('/form',['as'=>'admin.notice.noticeForm','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@noticeForm']);
		});
		/*产品*/
		Route::group(['prefix'=>'product'], function () {
			/*产品附加价格管理*/
			Route::group(['prefix'=>'PEP'], function () {
				/*产品附加价格列表*/
				Route::get('/',['as'=>'admin.productExtraPrice.PEPList','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@PEPList']);
				/*产品附加价格表单*/
				Route::get('/{id}/form',['as'=>'admin.productExtraPrice.PEPForm','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@PEPForm']);
				Route::get('/form',['as'=>'admin.productExtraPrice.PEPForm','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@PEPForm']);
			});
		});
		/*订单管理*/
		Route::group(['prefix'=>'orders'], function () {
			/*订单列表*/
			Route::get('/',['as'=>'admin.orders.ordersList','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@ordersList']);
			/*管理员-退款订单列表*/
			Route::get('/{id}/refundList',['as'=>'admin.orders.refundList','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@refundList']);
			/*管理员-退款订单*/
			Route::get('/{id}/refundApply',['as'=>'admin.orders.refundApply','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@refundApply']);
		});
		/*用户-押金退款申请*/
		Route::group(['prefix'=>'refundDepositApply'], function () {
			Route::get('/',['as'=>'admin.refundDepositApply','uses'=>'Readingbar\Back\Controllers\Orders\OrderRefundApplyController@index']);
			Route::post('/',['as'=>'admin.refundDepositApply','uses'=>'Readingbar\Back\Controllers\Orders\OrderRefundApplyController@complete']);
		});
		/*微信文章*/
		Route::group(['prefix'=>'wxArticle'], function () {
			/*微信文章列表*/
			Route::get('/',['as'=>'admin.wxArticle.wxArticleList','uses'=>'Readingbar\Back\Controllers\Wx\WxArticleController@wxArticleList']);
			/*微信文章表单*/
			Route::get('/{id}/form',['as'=>'admin.wxArticle.wxArticleForm','uses'=>'Readingbar\Back\Controllers\Wx\WxArticleController@wxArticleForm']);
			Route::get('/form',['as'=>'admin.wxArticle.wxArticleForm','uses'=>'Readingbar\Back\Controllers\Wx\WxArticleController@wxArticleForm']);
		});
		/*老师后台管理*/
		Route::group(['prefix'=>'teacher'], function () {
			/*star报告管理*/
			Route::group(['prefix'=>'starreport'], function () {
				/*报告列表*/
				Route::get('/',['as'=>'admin.starreport.starReportList','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@starReportList']);
				/*报告txt解析*/
				Route::post('/analysisTXT',['as'=>'admin.starreport.starReportList','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@uploadTxt']);
				/*下载报告*/
				Route::get('/downloadReport',['as'=>'admin.starreport.starReportForm','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@downloadReport']);
				/*报告表单*/
				Route::get('/{id}/form',['as'=>'admin.starreport.starReportForm','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@starReportForm']);
				Route::get('/form',['as'=>'admin.starreport.starReportForm','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@starReportForm']);
				/*报告书单*/
				Route::get('/{id}/booklist',['as'=>'admin.starreport.report_booklist','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportBooklistController@index']);
				Route::get('/booklist/getBooklist',['as'=>'admin.starreport.report_booklist','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportBooklistController@getBooklist']);
				Route::post('/booklist',['as'=>'admin.starreport.report_booklist','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportBooklistController@store']);
				Route::delete('/booklist',['as'=>'admin.starreport.report_booklist','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportBooklistController@destory']);
			});
			Route::get('/',['as'=>'admin.teacher','uses'=>'Readingbar\Back\Controllers\Teacher\TeacherController@index']);
			Route::get('/getBoughtInfo',['as'=>'admin.teacher.getBoughtInfo','uses'=>'Readingbar\Back\Controllers\Teacher\TeacherController@getBoughtInfo']);
		});
		Route::group(['prefix'=>'tstudents'], function () {
			// 老师查询购买记录
			Route::get('/{id}/boughtlog',['as'=>'admin.tstudents.boughtlog','uses'=>'Readingbar\Back\Controllers\Teacher\BoughtLogController@index']);
			Route::get('/{id}/getboughtlog',['as'=>'admin.tstudents.getboughtlog','uses'=>'Readingbar\Back\Controllers\Teacher\BoughtLogController@getLog']);
		});
		/*阅读指导后台管理*/
		Route::group(['prefix'=>'instructor'], function () {
			/*阅读指导后台首页*/
			Route::get('/',['as'=>'admin.instructor.index','uses'=>'Readingbar\Back\Controllers\Instructor\InstructorController@todayRegisterMemberList']);
			/*阅读指导后台-学生管理*/
			Route::get('/studentManage',['as'=>'admin.instructor_sm.index','uses'=>'Readingbar\Back\Controllers\Instructor\StudentsManageController@studentManageList']);
		});
		/*图书后台管理*/
		Route::group(['prefix'=>'booksManage'], function () {
			/*图书管理-导入界面*/
			Route::get('/booksImport',['as'=>'admin.booksImport.booksImport','uses'=>'Readingbar\Back\Controllers\Books\BooksImportController@booksImport']);
		});
		/*会员管理管理*/
		Route::group(['prefix'=>'members'], function () {
			/*会员列表*/
			Route::get('/',['as'=>'admin.members.membersList','uses'=>'Readingbar\Back\Controllers\Member\MemberController@membersList']);
			/*会员表单*/
			Route::get('/{id}/edit',['as'=>'admin.members.memberForm','uses'=>'Readingbar\Back\Controllers\Member\MemberController@memberForm']);
			
		});
	});
	/*后台-web*/
	
	
	/*后台-api*/
	Route::group(['middleware' => ['pauth','api'],'prefix'=>'admin'], function () {
		Route::group(['prefix'=>'api'], function () {
			/*阅读计划 借阅服务*/
			Route::group(['prefix'=>'readplan'], function () {
				/*获取阅读计划数据*/
				Route::get('/getReadPlans',['as'=>'admin.readplan.getReadPlans','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@getReadPlans']);
				/*获取阅读计划详情*/
				Route::get('/getReadPlanById',['as'=>'admin.readplan.getReadPlanById','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@getReadPlanById']);
				/*创建借阅服务计划*/
				Route::post('/createPlan',['as'=>'admin.readplan.createPlan','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@createPlan']);
				/*让会员确认阅读计划*/
				Route::get('/allowUserConfirm',['as'=>'admin.readplan.allowUserConfirm','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@allowUserConfirm']);
				/*撤回未确认的计划*/
				Route::get('/revokeReadPlan',['as'=>'admin.readplan.revokeReadPlan','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@revokeReadPlan']);
				/*上传AR报告*/
				Route::post('/uploadArReport',['as'=>'admin.readplan.uploadArReport','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@uploadArReport']);
				/*上传本月报告*/
				Route::post('/uploadMRReport',['as'=>'admin.readplan.uploadMRReport','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@uploadMRReport']);
				
				/*修改计划的起始和结束日期*/
				Route::get('/changeFromTo',['as'=>'admin.readplan.changeFromTo','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@changeFromTo']);
				/*书籍查询*/
				Route::get('/seachBooks',['as'=>'admin.readplan.seachBooks','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@seachBooks']);
				/*加入书籍*/
				Route::get('/addBookIntoPlan',['as'=>'admin.readplan.addBookIntoPlan','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@addBookIntoPlan']);
				/*移除书籍*/
				Route::get('/removeBookFromPlan',['as'=>'admin.readplan.removeBookFromPlan','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@removeBookFromPlan']);
				
				/*新增建议*/
				Route::get('/addRPProposal',['as'=>'admin.readplan.addRPProposal','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@addRPProposal']);
				/*编辑建议*/
				Route::get('/editRPProposal',['as'=>'admin.readplan.editRPProposal','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@editRPProposal']);
				/*删除建议*/
				Route::get('/deleteRPProposal',['as'=>'admin.readplan.deleteRPProposal','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@deleteRPProposal']);
				
				/*新增目标*/
				Route::get('/addRPGoals',['as'=>'admin.readplan.addRPGoals','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@addRPGoals']);
				/*编辑目标*/
				Route::get('/editRPGoals',['as'=>'admin.readplan.editRPGoals','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@editRPGoals']);
				/*删除目标*/
				Route::get('/deleteRPGoals',['as'=>'admin.readplan.deleteRPGoals','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@deleteRPGoals']);
				/*删除目标*/
				Route::get('/completeRPGoals',['as'=>'admin.readplan.completeRPGoals','uses'=>'Readingbar\Back\Controllers\ReadPlan\ReadPlanController@completeRPGoals']);
			});
			/*推广*/
			Route::group(['prefix'=>'promotion'], function () {
				/*获取推广员数据列表*/
				Route::get('/getPromotions',['as'=>'admin.promotion.getPromotions','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@getPromotions']);
				/*获取推广员数据数据*/
				Route::get('/getPromotion',['as'=>'admin.promotion.getPromotion','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@getPromotion']);
				/*获取推广员表单参数*/
				Route::get('/getFormPar',['as'=>'admin.promotion.getFormPar','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@getFormPar']);
				
				/*编辑数据*/
				Route::post('/editPromotion',['as'=>'admin.promotion.editPromotion','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@editPromotion']);
				
				/*获取推广员推广会员数据列表*/
				Route::get('/getMembers',['as'=>'admin.promotion.getMembers','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@getMembers']);
				/*获取推广员推广会员订单数据列表*/
				Route::get('/getMOrders',['as'=>'admin.promotion.getMOrders','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionController@getMOrders']);
			
				Route::group(['prefix'=>'type'], function () {
					/*获取公告列表*/
					Route::get('/getPromotionTypes',['as'=>'admin.TOPromotion.getPromotionTypes','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@getPromotionTypes']);
					/*获取公告详情*/
					Route::get('/getPromotionType',['as'=>'admin.TOPromotion.getPromotionType','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@getPromotionType']);
					/*编辑公告*/
					Route::post('/editPromotionType',['as'=>'admin.TOPromotion.editPromotionType','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@editPromotionType']);
					/*新增公告*/
					Route::post('/createPromotionType',['as'=>'admin.TOPromotion.createPromotionType','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@createPromotionType']);
					/*删除公告*/
					Route::post('/deletePromotionType',['as'=>'admin.TOPromotion.deletePromotionType','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@deletePromotionType']);
					/*获取推广员表单参数*/
					Route::get('/getFormPar',['as'=>'admin.TOPromotion.getFormPar','uses'=>'Readingbar\Back\Controllers\Promotion\PromotionTypeController@getFormPar']);
					
				
				});
			
			});
			/*后台用户收件箱*/
			Route::group(['prefix'=>'messagesBox'], function () {
				/*获取收件箱消息列表*/
				Route::get('/getMessages',['as'=>'admin.messagesBox.getMessages','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@getMessages']);
				/*获取收件箱消息详情*/
				Route::get('/getMessageDetail',['as'=>'admin.messagesBox.getMessageDetail','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@getMessageDetail']);
				/*删除消息*/
				Route::get('/deleteMessages',['as'=>'admin.messagesBox.deleteMessages','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@deleteMessages']);
				/*标记已读*/
				Route::get('/hasRed',['as'=>'admin.messagesBox.deleteMessages','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@hasRedMessages']);
				/*回复消息*/
				Route::post('/replyMessage',['as'=>'admin.messagesBox.replyMessage','uses'=>'Readingbar\Back\Controllers\Messages\MessagesBoxController@replyMessage']);
			});
			/*后台礼品管理*/
			Route::group(['prefix'=>'gift'], function () {
				Route::group(['prefix'=>'cardBatch'], function () {
					/*礼品卡批次-列表信息*/
					Route::get('/getBatches',['as'=>'admin.cardBacth.getBatches','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@getBatches']);
					/*礼品卡批次-单批次信息*/
					Route::get('/getBatch',['as'=>'admin.cardBacth.getBatch','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@getBatch']);
					/*礼品卡批次-新增*/
					Route::post('/create',['as'=>'admin.cardBacth.createBatch','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@createBatch']);
					/*礼品卡批次-编辑*/
					Route::post('/edit',['as'=>'admin.cardBacth.editBatch','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@editBatch']);
					/*礼品卡批次-编辑*/
					Route::post('/delete',['as'=>'admin.cardBacth.deleteBatch','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@deleteBatch']);
					/*礼品卡批次-获取关联产品*/
					Route::get('/getProducts',['as'=>'admin.cardBacth.getProducts','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@getProducts']);
					/*礼品卡批次-激活礼品卡*/
					Route::post('/activeCards',['as'=>'admin.cardBacth.activeCards','uses'=>'Readingbar\Back\Controllers\Gift\CardBatchController@activeCards']);
				});
				Route::group(['prefix'=>'cards'], function () {
					/*礼品卡-列表*/
					Route::get('/getCards',['as'=>'admin.cards.getCardsList','uses'=>'Readingbar\Back\Controllers\Gift\CardsController@getCardsList']);
					/*礼品卡-发送礼品信息*/
					Route::post('/setSent',['as'=>'admin.cards.setSent','uses'=>'Readingbar\Back\Controllers\Gift\CardsController@setSent']);
				});
			});
			/*公告*/
			Route::group(['prefix'=>'notice'], function () {
				/*获取公告列表*/
				Route::get('/getNotices',['as'=>'admin.notice.getNotices','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@getNotices']);
				/*获取公告详情*/
				Route::get('/getNotice',['as'=>'admin.notice.getNotice','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@getNotice']);
				/*编辑公告*/
				Route::post('/editNotice',['as'=>'admin.notice.editNotice','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@editNotice']);
				/*新增公告*/
				Route::post('/createNotice',['as'=>'admin.notice.createNotice','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@createNotice']);
				/*删除公告*/
				Route::post('/deleteNotice',['as'=>'admin.notice.deleteNotice','uses'=>'Readingbar\Back\Controllers\Notice\NoticeController@deleteNotice']);
			});
			/*优惠券*/
			Route::group(['prefix'=>'discount'], function () {
				/*获取优惠券折线图*/
				Route::get('/lc',['as'=>'admin.discount.getLineChart','uses'=>'Readingbar\Back\Controllers\Discount\DiscountController@getLineChart']);
				/*获取优惠券饼图*/
				Route::get('/pc',['as'=>'admin.discount.getPieChart','uses'=>'Readingbar\Back\Controllers\Discount\DiscountController@getPieChart']);
				
				/*优惠券类型列表*/
				Route::get('/type/getDiscountTypes',['as'=>'admin.discountType.getDiscountTypes','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@getDiscountTypes']);
				/*获取优惠券类型详情*/
				Route::get('/type/getDiscountType',['as'=>'admin.discountType.getDiscountType','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@getDiscountType']);
				/*编辑优惠券类型*/
				Route::post('/type/editDiscountType',['as'=>'admin.discountType.editDiscountType','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@editDiscountType']);
				/*新增优惠券类型*/
				Route::post('/type/createDiscountType',['as'=>'admin.discountType.createDiscountType','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@createDiscountType']);
				/*删除优惠券类型*/
				Route::post('/type/deleteDiscountType',['as'=>'admin.discountType.deleteDiscountType','uses'=>'Readingbar\Back\Controllers\Discount\DiscountTypeController@deleteDiscountType']);
			});
			/*产品*/
			Route::group(['prefix'=>'product'], function () {
				/*产品附加价格管理*/
				Route::group(['prefix'=>'PEP'], function () {
					/*获取产品附加价格列表*/
					Route::get('/getPEPs',['as'=>'admin.productExtraPrice.getPEPs','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@getPEPs']);
					/*获取产品附加价格详情*/
					Route::get('/getPEP',['as'=>'admin.productExtraPrice.getPEP','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@getPEP']);
					/*获取产品附加价格表单参数*/
					Route::get('/getFormPar',['as'=>'admin.productExtraPrice.getFormPar','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@getFormPar']);
					/*新增产品附加价格*/
					Route::post('/createPEP',['as'=>'admin.productExtraPrice.createPEP','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@createPEP']);
					/*编辑产品附加价格*/
					Route::post('/editPEP',['as'=>'admin.productExtraPrice.editPEP','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@editPEP']);
					/*删除产品附加价格*/
					Route::post('/deletePEP',['as'=>'admin.productExtraPrice.deletePEP','uses'=>'Readingbar\Back\Controllers\Product\ProductExtraPriceController@deletePEP']);
				});
			});
			/*老师后台管理*/
			Route::group(['prefix'=>'teacher'], function () {
				/*star报告管理*/
				Route::group(['prefix'=>'starreport'], function () {
					/*获取报告列表*/
					Route::get('/getStarReports',['as'=>'admin.starreport.getStarReports','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@getStarReports']);
					/*获取报告详情*/
					Route::get('/getStarReport',['as'=>'admin.starreport.getStarReport','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@getStarReport']);
					/*获取报告详情*/
					Route::get('/getStudents',['as'=>'admin.starreport.getStudents','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@getStudents']);
						
					/*创建报告*/
					Route::post('/createStarReport',['as'=>'admin.starreport.createStarReport','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@createStarReport']);
					/*编辑报告*/
					Route::post('/editStarReport',['as'=>'admin.starreport.editStarReport','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@editStarReport']);
					/*删除报告*/
					Route::post('/deleteStarReport',['as'=>'admin.starreport.deleteStarReport','uses'=>'Readingbar\Back\Controllers\Teacher\StarReportController@deleteStarReport']);
				});
			});
			/*阅读指导后台管理*/
			Route::group(['prefix'=>'instructor'], function () {
				/*阅读指导后台管理-获取当日报名学生信息*/
				Route::get('/getTodayRegisterMemberList',['as'=>'admin.instructor.getTodayRegisterMemberList','uses'=>'Readingbar\Back\Controllers\Instructor\InstructorController@getTodayRegisterMemberList']);
				Route::group(['prefix'=>'studentManage'], function () {
					/*获取学生列表*/
					Route::get('/getStudentManageList',['as'=>'admin.instructor_sm.getStudentManageList','uses'=>'Readingbar\Back\Controllers\Instructor\StudentsManageController@getStudentManageList']);
					/*获取用于分配的老师*/
					Route::get('/getTeachersList',['as'=>'admin.instructor_sm.getTeachersList','uses'=>'Readingbar\Back\Controllers\Instructor\StudentsManageController@getTeachersList']);
					/*分配老师*/
					Route::post('/asignTeacher',['as'=>'admin.instructor_sm.asignTeacher','uses'=>'Readingbar\Back\Controllers\Instructor\StudentsManageController@asignTeacher']);
					/*冻结学生服务*/
					Route::post('/freezeService',['as'=>'admin.instructor_sm.freezeService','uses'=>'Readingbar\Back\Controllers\Instructor\StudentsManageController@freezeService']);
				});
			});
			/*图书后台管理*/
			Route::group(['prefix'=>'booksManage'], function () {
				/*图书管理-导入图书*/
				Route::post('/doImport',['as'=>'admin.booksImport.doImport','uses'=>'Readingbar\Back\Controllers\Books\BooksImportController@doImport']);
				/*图书管理-获取未处理书籍*/
				Route::get('/untreatedBooks',['as'=>'admin.booksImport.untreatedBooks','uses'=>'Readingbar\Back\Controllers\Books\BooksImportController@untreatedBooks']);
				/*图书管理-人工处理书籍*/
				Route::post('/manualHandling',['as'=>'admin.booksImport.manualHandling','uses'=>'Readingbar\Back\Controllers\Books\BooksImportController@manualHandling']);
				/*图书管理-自动处理书籍*/
				Route::post('/dellBooks',['as'=>'admin.booksImport.dellBooks','uses'=>'Readingbar\Back\Controllers\Books\BooksImportController@dellBooks']);
			});
			/*微信文章*/
			Route::group(['prefix'=>'wxArticle'], function () {
				/*获取微信文章列表*/
				Route::get('/getWxArticles',['as'=>'admin.wxArticle.getWxArticles','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@getWxArticles']);
				/*获取微信文章详情*/
				Route::get('/getWxArticle',['as'=>'admin.wxArticle.getWxArticle','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@getWxArticle']);
				/*编辑微信文章*/
				Route::post('/editWxArticle',['as'=>'admin.wxArticle.editWxArticle','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@editWxArticle']);
				/*新增微信文章*/
				Route::post('/createWxArticle',['as'=>'admin.wxArticle.createWxArticle','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@createWxArticle']);
				/*删除微信文章*/
				Route::post('/deleteWxArticle',['as'=>'admin.wxArticle.deleteWxArticle','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@deleteWxArticle']);
				/*文章置顶*/
				Route::post('/setTop',['as'=>'admin.wxArticle.setTop','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@setTop']);
				/*文章取消置顶*/
				Route::post('/cancelTop',['as'=>'admin.wxArticle.cancelTop','uses'=>'Readingbar\Back\Controllers\WX\WxArticleController@cancelTop']);
			});
			
			/*订单管理*/
			Route::group(['prefix'=>'orders'], function () {
				/*获取订单列表*/
				Route::get('/getOrders',['as'=>'admin.orders.getOrders','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@getOrders']);
				/*获取退款订单列表*/
				Route::get('/getRefunds',['as'=>'admin.orders.getRefunds','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@getRefunds']);
				/*获取订单详情*/
				Route::get('/getOrder',['as'=>'admin.orders.getOrder','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@getOrder']);
				/*创建退款订单*/
				Route::post('/createRefund',['as'=>'admin.orders.createRefund','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@createRefund']);
				/*获取产品*/
				Route::get('/getProducts',['as'=>'admin.orders.getProducts','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@getProducts']);
				/*获取推广员信息*/
				Route::get('/getPromoters',['as'=>'admin.orders.getPromoters','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@getPromoters']);
				/*导出订单信息*/
				Route::get('/exportOrders',['as'=>'admin.orders.exportOrders','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@exportOrders']);
				/*订单表单*/
				Route::get('/{id}/form',['as'=>'admin.orders.orderForm','uses'=>'Readingbar\Back\Controllers\Orders\OrderController@orderForm']);
			
				
			});
			/*会员管理管理*/
			Route::group(['prefix'=>'members'], function () {
				/*会员列表*/
				Route::get('/getMembers',['as'=>'admin.members.getMembers','uses'=>'Readingbar\Back\Controllers\Member\MemberController@getMembers']);
				/*折线图信息*/
				Route::get('/lcom',['as'=>'admin.members.lcom','uses'=>'Readingbar\Back\Controllers\Member\MemberController@getLineChart']);
				/*更新会员信息*/
				Route::post('/update',['as'=>'admin.members.update','uses'=>'Readingbar\Back\Controllers\Member\MemberController@update']);
				
				
			});
			/*网站设置*/
			Route::group(['prefix'=>'setting'], function () {
				/*获取设置列表*/
				Route::get('/getSettings',['as'=>'admin.setting.getSettings','uses'=>'Readingbar\Back\Controllers\Setting\SettingController@getSettings']);
				/*编辑设置*/
				Route::post('/editSetting',['as'=>'admin.setting.editSetting','uses'=>'Readingbar\Back\Controllers\Setting\SettingController@editSetting']);
			});
		});
	});
	/*后台-api*/
	
	
	Route::group(['middleware' => 'pauth','prefix'=>'admin'], function () {
		/*阅读指导-star报告监控*/
		Route::group(['prefix'=>'SReportMonitoring','as'=>'admin.SReportMonitoring.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Instructor\SReportMonitoringController@viewList']);
 			Route::group(['middleware' => 'api','prefix'=>'api'], function () {
				Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Instructor\SReportMonitoringController@getList']);
				Route::get('/export',['as'=>'export','uses'=>'Readingbar\Back\Controllers\Instructor\SReportMonitoringController@export']);
			});
		});
		/*阅读指导-阅读计划监控*/
		Route::group(['prefix'=>'RPMonitoring','as'=>'admin.RPMonitoring.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Instructor\RPMonitoringController@viewList']);
			Route::group(['middleware' => 'api','prefix'=>'api'], function () {
				Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Instructor\RPMonitoringController@getList']);
			});
		});
		/*阅读指导-书库监控*/
		Route::group(['prefix'=>'BookMonitoring','as'=>'admin.BookMonitoring.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Instructor\BookMonitoringController@viewList']);
			Route::group(['middleware' => 'api','prefix'=>'api'], function () {
				Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Instructor\BookMonitoringController@getList']);
			});
		});
		/*阅读指导-老师沟通记录查询*/
		Route::group(['prefix'=>'STSessionsMonitoring','as'=>'admin.STSessionsMonitoring.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Instructor\STSessionsMonitoringController@viewList']);
			Route::group(['middleware' => 'api','prefix'=>'api'], function () {
				Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Instructor\STSessionsMonitoringController@getList']);
			});
		});
		/*阅读指导-排行管理*/
		Route::group(['prefix'=>'ranking','as'=>'admin.ranking.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@viewRanking']);
			Route::get('/getRs',['as'=>'getRs','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@getRs']);
			Route::get('/getStudents',['as'=>'getStudents','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@getStudents']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@create']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@delete']);
			Route::post('/awardPoint',['as'=>'awardPoint','uses'=>'Readingbar\Back\Controllers\Instructor\RankingController@awardPoint']);
		});
		
		/*积分产品分类管理*/
			Route::group(['prefix'=>'ppc','as'=>'admin.ppc.'], function () {
				Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@viewList']);
				Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@viewForm']);
				Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@getList']);
				Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@create']);
				Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@update']);
				Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductCatagoryController@delete']);
			});
		/*积分产品管理*/
		Route::group(['prefix'=>'PointProduct','as'=>'admin.PointProduct.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@viewList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@viewForm']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@getList']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@create']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@update']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Spoint\PointProductController@delete']);
		});
		/*积分管理*/
		Route::group(['prefix'=>'PointManage','as'=>'admin.PointManage.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@viewList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@viewForm']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@getList']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@create']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@update']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@delete']);
		});
		/*积分日志管理*/
		Route::group(['prefix'=>'PointLog','as'=>'admin.PointLog.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Spoint\PointLogController@viewList']);Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointController@getList']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointLogController@getList']);
			Route::get('/getStudents',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointLogController@getStudents']);
			Route::post('/giveStudentPoint',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointLogController@giveStudentPoint']);
			Route::post('/retract',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointLogController@retract']);
		});
		/*积分订单管理管理*/
		Route::group(['prefix'=>'PointOrder','as'=>'admin.PointOrder.'], function () {
			Route::get('/',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Spoint\PointOrderController@viewList']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Spoint\PointOrderController@getList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Spoint\PointOrderController@viewForm']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Spoint\PointOrderController@update']);
			Route::post('/edit',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Spoint\PointOrderController@retract']);
		});
		/*优惠券赠送功能*/
		Route::group(['prefix'=>'DiscountGive','as'=>'admin.DiscountGive.'], function () {
			Route::get('/',['as'=>'giveDiscount','uses'=>'Readingbar\Back\Controllers\Discount\DiscountGiveController@index']);
			Route::get('/giveDiscount',['as'=>'giveDiscount','uses'=>'Readingbar\Back\Controllers\Discount\DiscountGiveController@giveDiscountToMembers']);
			Route::get('/getProgress',['as'=>'getProgresss','uses'=>'Readingbar\Back\Controllers\Discount\DiscountGiveController@getProgress']);
		});
		
		/*合作伙伴*/
		Route::group(['prefix'=>'partner/friendlyLink','as'=>'admin.FriendlyLink.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@viewList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@viewForm']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@getList']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@create']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@update']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Partner\FriendlyLinkController@delete']);
		});
		/*写点想法*/
		Route::group(['prefix'=>'customer/idea','as'=>'admin.CustomerIdea.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@viewList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@viewForm']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@getList']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@create']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@update']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\Customer\CustomerIdeaController@delete']);
		});
		/*购买记录*/
		Route::group(['prefix'=>'boughtLog','as'=>'admin.boughtLog.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Orders\BoughtLogController@index']);
			Route::get('/getLog',['as'=>'getLog','uses'=>'Readingbar\Back\Controllers\Orders\BoughtLogController@getLog']);
		});
		
		/*按钮链接*/
		Route::group(['prefix'=>'btnLink','as'=>'admin.BtnLink.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@viewList']);
			Route::get('/form',['as'=>'form','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@viewForm']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@getList']);
			Route::post('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@create']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@update']);
			Route::post('/delete',['as'=>'delete','uses'=>'Readingbar\Back\Controllers\BtnLink\BtnLinkController@delete']);
		});
		
		/*库存日志*/
		Route::group(['prefix'=>'bookStorageLog','as'=>'admin.bookStorageLog.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Books\bookStorageLogController@index']);
			Route::get('/getLogs',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Books\bookStorageLogController@getLogs']);
		});
		/*老师学生管理*/
		Route::group(['prefix'=>'tstudents'], function () {
			//Route::resource('/tstudents','Readingbar\Back\Controllers\Teacher\TstudentsController');
			Route::get('/borrow',['as'=>'admin.tstudents.borrow','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@BorrowStudents']);
			Route::get('/',['as'=>'admin.tstudents.index','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@index']);
			Route::get('/readPlansView',['as'=>'admin.tstudents.readPlansView','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@readPlansView']);
			Route::get('/exportStudents',['as'=>'admin.tstudents.exportStudents','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@exportStudents']);
			Route::get('/{type}',['as'=>'admin.tstudents.show','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@show']);
			Route::post('/{type}',['as'=>'admin.tstudents.store','uses'=>'Readingbar\Back\Controllers\Teacher\TstudentsController@store']);
		});
		/* star账号管理*/
		Route::group(['prefix'=>'staraccount'], function () {
			Route::get('',['as'=>'admin.staraccount.index','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@index']);
			Route::get('/create',['as'=>'admin.staraccount.create','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@create']);
			Route::get('/list',['as'=>'admin.staraccount.list','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@accountsList']);
			Route::get('/changeStatus',['as'=>'admin.staraccount.changeStatus','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@changeStatus']);
			Route::get('/changeGrade',['as'=>'admin.staraccount.changeGrade','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@changeGrade']);
			Route::get('/resetPassword',['as'=>'admin.staraccount.resetPassword','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountController@resetPassword']);
		});
		/* star账号分配*/
		Route::group(['prefix'=>'staraccountasign'], function () {
			Route::get('/',['as'=>'admin.staraccountasign.index','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountAsignController@index']);
			Route::get('/appliesList',['as'=>'admin.staraccountasign.appliesList','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountAsignController@appliesList']);
			Route::get('/accounts',['as'=>'admin.staraccountasign.accounts','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountAsignController@starAccountsOfTeacher']);
			Route::get('/asign',['as'=>'admin.staraccountasign.asign','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountAsignController@asign']);
			Route::get('/informParents',['as'=>'admin.staraccountasign.informParents','uses'=>'Readingbar\Back\Controllers\Teacher\StarAccountAsignController@informParents']);
		});
		// 个人书架
		Route::resource('/favorites','Readingbar\Back\Controllers\Teacher\FavoritesController');
		/* 产品管理*/
		Route::group(['prefix'=>'product'], function () {
			Route::get('/list',['as'=>'admin.product.list','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@productList']);
			Route::get('/getList',['as'=>'admin.product.getList','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@getProductList']);
		});
		/* 产品购买校验*/
		Route::group(['prefix'=>'productBuyCheck','as'=>'admin.productBuyCheck.'], function () {
			Route::get('/{id}/list',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@productPreBuyRuleList']);
			Route::get('/{id}/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@RuleFormCreate']);
			Route::get('/{id}/edit',['as'=>'edit','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@RuleFormEdit']);
			Route::get('/getList',['as'=>'getList','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@getProductPreBuyRuleList']);
			Route::get('/getById',['as'=>'getById','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@getProductPreBuyRuleById']);
			Route::post('/destroy',['as'=>'desory','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@destroy']);
			Route::post('/store',['as'=>'store','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@store']);
			Route::post('/update',['as'=>'update','uses'=>'Readingbar\Back\Controllers\Product\ProductBuyCheckSettingController@update']);
		});
		/* 产品续费优惠 */
		Route::group(['prefix'=>'productRenewDiscount','as'=>'admin.productRenewDiscount.'], function () {
			Route::get('/',['as'=>'index','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@index']);
			Route::get('/create',['as'=>'create','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@create']);
			Route::get('/{id}/edit',['as'=>'edit','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@edit']);
			Route::post('/store',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@store']);
			Route::post('/{id}/update',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@update']);
			Route::post('/{id}/delete',['as'=>'list','uses'=>'Readingbar\Back\Controllers\Product\ProductRenewDiscountController@destroy']);
		});
		Route::group(['prefix'=>'express'], function () {
			/*订单关联运费*/
			Route::get('/order/{id}',['as'=>'admin.expressOrder','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@orderIndex']);
			Route::post('/order/store',['as'=>'admin.expressOrder','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@storeOrder']);
			Route::delete('/order/delete',['as'=>'admin.expressOrder','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@deleteOrder']);
			/*借书计划关联运费*/
			Route::get('/plan/{id}',['as'=>'admin.expressPlan','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@planIndex']);
			Route::post('/plan/store',['as'=>'admin.expressPlan','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@storePlan']);
			Route::delete('/plan/delete',['as'=>'admin.expressPlan','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@deletePlan']);
			/*物流查询*/
			Route::get('/traces/{id}',['as'=>'admin.expressTraces','uses'=>'Readingbar\Back\Controllers\Express\ExpressController@getTraces']);
		});
		Route::resource('/productRenewDiscount','Readingbar\Back\Controllers\Product\ProductRenewDiscountController');
	});
?>