<a href="#" data-toggle="modal" data-target="#Cities">{$_modx->getPlaceholder("cf.city")? : 'Выберите город'}</a>
{set $cities = ''}
{foreach $rows as $row}
    {set $cities = $cities~'<li class="cf-city-item"><a href="'~$row.link~'" rel="nofollow" class="'~$row.active~'">'~$row.city~'</a></li>'}
{/foreach}

{set $modal = '
    <!--noindex-->
    <div class="modal fade" id="Cities" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать город</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div>
                        <input type="text" placeholder="Поиск по городу" class="form-control cf-city-input">
                    </div>
                    <br/>
                    <ul>
                        '~$cities~'
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--/noindex-->
'}

{$modal | htmlToBottom}
