 <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">备注</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.memo" name="memo" type="text" class="form-control">
                                    	<label v-if="errors.memo" class="error">[[ errors.memo[0] ]]</label>
                                    </div>
                                </div>
 <div class="hr-line-dashed"></div>
 <div class="form-group"><label class="col-sm-2 control-label">阶段性pdf报告</label>
                                    <div class="col-sm-10">
                                    	<input v-model="form.pdf_stage" readonly="readonly"  onclick="$('input[name=pdf_stage]').click()" type="text" class="form-control">
                                    	<input style="display: none" v-on:change="showFile($event,'pdf_stage')" name="pdf_stage"  type="file" class="form-control">
                                    	<label v-if="errors.pdf_stage" class="error">[[ errors.pdf_stage[0] ]]</label>
                                    </div>
                                </div>