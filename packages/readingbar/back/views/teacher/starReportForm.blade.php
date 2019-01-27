  <div class="hr-line-dashed"></div>
  								<div class="form-group"><label class="col-sm-2 control-label">STAR账号</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.star_account" name="star_account" type="text" class="form-control">
                                    	<label v-if="errors.star_account" class="error">[[ errors.star_account[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">测试时间</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.test_date" name="test_date" type="text" class="form-control">
                                    	<label v-if="errors.test_date" class="error">[[ errors.test_date[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">测试用时</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.time_used" name="time_used" type="text" class="form-control">
                                    	<label v-if="errors.time_used" class="error">[[ errors.time_used[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Grade</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.grade" name="grade" type="text" class="form-control">
                                    	<label v-if="errors.grade" class="error">[[ errors.grade[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">SS</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.ss" name="ss" type="text" class="form-control">
                                    	<label v-if="errors.ss" class="error">[[ errors.ss[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">PR</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.pr" name="pr" type="text" class="form-control">
                                    	<label v-if="errors.pr" class="error">[[ errors.pr[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Est.OR</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.estor" name="estor" type="text" class="form-control">
                                    	<label v-if="errors.estor" class="error">[[ errors.estor[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">GE</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.ge" name="ge" type="text" class="form-control">
                                    	<label v-if="errors.ge" class="error">[[ errors.ge[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">蓝思值</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.lm" name="lm" type="text" class="form-control">
                                    	<label v-if="errors.lm" class="error">[[ errors.lm[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">IRL</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.irl" name="irl" type="text" class="form-control">
                                    	<label v-if="errors.irl" class="error">[[ errors.irl[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">ZPD</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.zpd" name="zpd" type="text" class="form-control">
                                    	<label v-if="errors.zpd" class="error">[[ errors.zpd[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">词汇认知</label> -->
<!--                                     <div class="col-sm-10"> -->
<!--                                     	<input v-model="form.wks" name="wks" type="text" class="form-control"> -->
<!--                                     	<label v-if="errors.wks" class="error">[[ errors.wks[0] ]]</label> -->
<!--                                     </div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">阅读理解</label> -->
<!--                                     <div class="col-sm-10"> -->
<!--                                     	<input v-model="form.cscm" name="cscm" type="text" class="form-control"> -->
<!--                                     	<label v-if="errors.cscm" class="error">[[ errors.cscm[0] ]]</label> -->
<!--                                     </div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">阅读分析</label> -->
<!--                                      <div class="col-sm-10"> -->
<!--                                     	<input v-model="form.alt" name="alt" type="text" class="form-control"> -->
<!--                                     	<label v-if="errors.alt" class="error">[[ errors.alt[0] ]]</label> -->
<!--                                     </div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
<!--                                 <div class="form-group"><label class="col-sm-2 control-label">修辞手法</label> -->
<!--                                     <div class="col-sm-10"> -->
<!--                                     	<input v-model="form.uac" name="uac" type="text" class="form-control"> -->
<!--                                     	<label v-if="errors.uac" class="error">[[ errors.uac[0] ]]</label> -->
<!--                                     </div> -->
<!--                                 </div> -->
<!--                                 <div class="hr-line-dashed"></div> -->
                                <div class="form-group"><label class="col-sm-2 control-label">思维能力</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.aaet" name="aaet" type="text" class="form-control">
                                    	<label v-if="errors.aaet" class="error">[[ errors.aaet[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">词汇理解能力</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.vo" name="vo" type="text" class="form-control">
                                    	<label v-if="errors.vo" class="error">[[ errors.vo[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">文章内容理解和应用能力</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.ui" name="ui" type="text" class="form-control">
                                    	<label v-if="errors.ui" class="error">[[ errors.ui[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">文学素养能力</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.er" name="er" type="text" class="form-control">
                                    	<label v-if="errors.er" class="error">[[ errors.er[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">词汇认知能力</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.wr" name="wr" type="text" class="form-control">
                                    	<label v-if="errors.wr" class="error">[[ errors.wr[0] ]]</label>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">英文pdf报告</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.pdf_en" readonly="readonly" onclick="$('input[name=pdf_en]').click()" type="text" class="form-control">
                                    	<input style="display: none" v-on:change="showFile($event,'pdf_en')" name="pdf_en"  type="file" class="form-control">
                                    	<label v-if="errors.pdf_en" class="error">[[ errors.pdf_en[0] ]]</label>
                                    </div>
                                </div>