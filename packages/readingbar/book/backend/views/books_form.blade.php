
								@if(isset($books['id']))
									<input type="hidden" name="id" value="{{ $books['id'] or '' }}"><br>
									<input type="hidden" name="book[id]" value="{{ $books['id'] or '' }}"><br>
								@endif
								
                                <div class="form-group {{ $errors->has('book_name')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_book_name') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[book_name]" value="{{ $books['book_name'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('book_name'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('book_name') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('author')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_author') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[author]" value="{{ $books['author'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('author'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('author') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('ISBN')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_ISBN') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[ISBN]" value="{{ $books['ISBN'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('ISBN'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('ISBN') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('LCCN')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_LCCN') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[LCCN]" value="{{ $books['LCCN'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('LCCN'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('LCCN') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('publisher')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_publisher') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[publisher]" value="{{ $books['publisher'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('publisher'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('publisher') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('PublishDate')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_PublishDate') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[PublishDate]" value="{{ $books['PublishDate'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('PublishDate'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('PublishDate') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('ARQuizNo')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_ARQuizNo') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[ARQuizNo]" value="{{ $books['ARQuizNo'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('ARQuizNo'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('ARQuizNo') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('language')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_language') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[language]" value="{{ $books['language'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('language'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('language') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('summary')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_summary') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[summary]" value="{{ $books['summary'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('summary'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('summary') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('ARQuizType')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_ARQuizType') }}</label>
                                    <div class="col-sm-10">
	                                    <select name="book[ARQuizType]" class="form-control">
	                                    	<option value="RP" 	{{ isset($books['ARQuizType'])?($books['ARQuizType']=='RP'?"selected='selected'":''):'' }}>RP</option>; 
	                                    	<option value="LS"  {{ isset($books['ARQuizType'])?($books['ARQuizType']=='LS'?"selected='selected'":''):'' }}>LS</option>; 
	                                    	<option value="RV"  {{ isset($books['ARQuizType'])?($books['ARQuizType']=='RV'?"selected='selected'":''):'' }}>RV</option>; 
	                                    	<option value="VP"  {{ isset($books['ARQuizType'])?($books['ARQuizType']=='VP'?"selected='selected'":''):'' }}>VP</option>; 
	                                    </select>
	                                    @if ($errors->has('ARQuizType'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('ARQuizType') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('type')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_type') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[type]" value="{{ $books['type'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('type'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('type') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('WordCount')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_WordCount') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[WordCount]" value="{{ $books['WordCount'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('WordCount'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('WordCount') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('PageCount')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_PageCount') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[PageCount]" value="{{ $books['PageCount'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('PageCount'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('PageCount') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('rating')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_rating') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[rating]" value="{{ $books['rating'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('rating'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('rating') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('IL')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_IL') }}</label>
                                    <div class="col-sm-10">
	                                    <select name="book[IL]" class="form-control">
	                                    	<option value="LG" 	{{ isset($books['IL'])?($books['IL']=='LG'?"selected='selected'":''):'' }}>LG</option>; 
	                                    	<option value="MG"  {{ isset($books['IL'])?($books['IL']=='MG'?"selected='selected'":''):'' }}>MG</option>; 
	                                    	<option value="MG+" {{ isset($books['IL'])?($books['IL']=='MG+'?"selected='selected'":''):'' }}>MG+</option>; 
	                                    	<option value="UG"  {{ isset($books['IL'])?($books['IL']=='UG'?"selected='selected'":''):'' }}>UG</option>; 
	                                    </select>
	                                    @if ($errors->has('IL'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('IL') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('BL')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_BL') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[BL]" value="{{ $books['BL'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('BL'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('BL') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('ARPts')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_ARPts') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[ARPts]" value="{{ $books['ARPts'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('ARPts'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('ARPts') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('atos')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_atos') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[atos]" value="{{ $books['atos'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('atos'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('atos') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('topic')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_topic') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[topic]" value="{{ $books['topic'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('topic'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('topic') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
	   				
                                <div class="form-group {{ $errors->has('series')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_series') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[series]" value="{{ $books['series'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('series'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('series') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('price_rmb')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_price_rmb') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[price_rmb]" value="{{ $books['price_rmb'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('price_rmb'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('price_rmb') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('price_usd')?'has-error':''}}"><label class="col-sm-2 control-label">{{ trans('books.column_price_usd') }}</label>
                                    <div class="col-sm-10">
	                                    <input type="text" name="book[price_usd]" value="{{ $books['price_usd'] or '' }}" class="form-control"> 
	                                    @if ($errors->has('price_usd'))
											<span class="help-block m-b-none">
												<strong>{{ $errors->first('price_usd') }}</strong>
											</span>
										@endif
                                    </div>
                                </div>
                                
                                