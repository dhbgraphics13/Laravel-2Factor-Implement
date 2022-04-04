
<div class="row">
    <div class="col-xl-2 col-sm-12">
        <label  class="label">Choose Printing Modules</label>
    </div>

    <div class="col-xl-10 col-sm-12">
        <div class="row">

                @if(count($printing_modules) > 0)

                   @foreach($printing_modules as $module)

                         <div class="col-xl-3 col-sm-6" style="box-shadow: 2px 2px 2px 2px #eeeeee;">
                        <div class="mt-4">
                            <div class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-primary mb-3">
                                <label><input type="checkbox"  name="printing_modules{{$module->category_id }}[]"  value="{{ $module->id }}">  {{$module->module_name }}</label>
                                {{--<input type="checkbox" class="custom-control-input" name="printing_modules{{$module->category_id }}[]"  value="{{ $module->id }}" >
                                <label class="custom-control-label" > {{$module->module_name }}</label>--}}
                            </div>
                        </div>

                             @if(isset($module['children']) && is_array($module['children'])  && count($module['children']) > 0)
                                 @foreach($module['children'] as $child)
                                     <div class="mt-2" style="padding-left: 15px;" >
                                         <div class="custom-control custom-checkbox custom-checkbox-outline custom-checkbox-primary mb-3">
                                             <label><input type="checkbox"  name="printing_modules{{$module->category_id }}[]"  value="{{ $child->id }}">  {{$child->module_name }}</label>
                                             {{--<input type="checkbox" class="custom-control-input" name="printing_modules{{$module->category_id }}[]" id="printing_modules{{makeModuleSlug($child->module_name)}}" value="{{ $child->id }}" >
                                             <label class="custom-control-label text-info" for="printing_modules" style="font-weight: normal;">{{$child->module_name }}  (child)</label>--}}
                                         </div>
                                     </div>
                                 @endforeach
                             @endif
                    </div>
                   @endforeach
               @endif
        </div>
    </div>

</div>
</div>




