<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MissingInfluencersExport implements FromCollection, WithHeadings, WithStartRow
{

    public $data;

    public function headings(): array
    {
        return [
            'Influencer',
            'المعلن',
            'Snapchat Handler',
            'Instagram Handler',
            'TikTok Handler',
            'Twitter Handler',
            'FaceBook Handler',
            'Category',
            'Gender',
            'Nationality',
            'Country of Residence',
            'City',
            '',
            ' Weight(The daily posting)',
            'Home Endoresment Price',
            'Location Visit Price',
            ' Type',
            ' Active',
            'Weight(The daily posting) ',
            'Psot Price',
            'Story Price ',
            'Type ',
            'Active ',
            'Weight(The daily posting)   ',
            'Psot Price  ',
            'Live Price',
            'Type  ',
            'Active  ',
            'Weight(The daily posting)    ',
            'Tweet/Quote Price',
            'Retweet Price',
            'Type     ',
            'Active   ',
            'Weight(The daily posting)      ',
            'Post Price',
            'Type       ',
            'Active     ',
            'Added Date',
            'Active',
            '  ',
            '   ',
            '    ',
            '     ',
            '      ',
            '       ',
            '        ',
            'Errors'
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): \Illuminate\Support\Collection
    {
        foreach ($this->data as $datum) {
            $data [] = [
                'Influencer'=>$datum[0]??" ",
                'المعلن'=>$datum[1]??" ",
                'Snapchat Handler'=>$datum[2]??" ",
                'Instagram Handler'=>$datum[3]??" ",
                'TikTok Handler'=>$datum[4]??" ",
                'Twitter Handler'=>$datum[5]??" ",
                'FaceBook Handler'=>$datum[6]??" ",
                'Category'=>$datum[7]??" ",
                'Gender'=>$datum[8]??" ",
                'Nationality'=>$datum[9]??" ",
                'Country of Residence'=>$datum[10]??" ",
                'City'=>$datum[11]??" ",
                ''=>$datum[12]??" ",
                'Weight(The daily posting)  '=>$datum[13]??" ",
                'Home Endoresment Price'=>$datum[14]??" ",
                'Location Visit Price'=>$datum[15]??" ",
                'Type '=>$datum[16]??" ",
                'Active '=>$datum[17]??" ",
                'Weight(The daily posting) '=>$datum[18]??" ",
                'Psot Price '=>$datum[19]??" ",
                'Story Price'=>$datum[20]??" ",
                'Type  '=>$datum[21]??" ",
                'Active  '=>$datum[22]??" ",
                'Weight(The daily posting)    '=>$datum[23]??" ",
                'Psot Price'=>$datum[24]??" ",
                'Live Price'=>$datum[25]??" ",
                'Type   '=>$datum[26]??" ",
                'Active   '=>$datum[27]??" ",
                ' Weight(The daily posting)'=>$datum[28]??" ",
                'Tweet/Quote Price'=>$datum[29]??" ",
                'Retweet Price'=>$datum[30]??" ",
                ' Type'=>$datum[31]??" ",
                ' Active'=>$datum[32]??" ",
                'Weight(The daily posting)'=>$datum[34]??" ",
                'Post Price'=>$datum[35]??" ",
                'Type'=>$datum[36]??" ",
                '  Active'=>$datum[37]??" ",
                'Added Date'=>$datum[38]??" ",
                'Active'=>$datum[39]??" ",
                '  '=>$datum[40]??" ",
                '   '=>$datum[41]??" ",
                '    '=>$datum[42]??" ",
                '     '=>$datum[43]??" ",
                '      '=>$datum[44]??" ",
                '       '=>$datum[45]??" ",
                '        '=>$datum[47]??" ",
                'Errors'=>end($datum)
            ];

        }
        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
