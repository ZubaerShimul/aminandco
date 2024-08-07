<?php

use App\Models\Transaction;
use Carbon\Carbon;


function allSetting($array = NULL)
{
    return false;
}


function errorResponse($message = null, $data = null)
{
    $message = $message ? $message :  __('Something went wrong');
    return [
        'success'   => false,
        'message'   => $message,
        'data'      =>  $data
    ];
}

function successResponse($message = null, $data = [])
{
    $message = $message ? $message :  __('Success');
    return [
        'success'   => true,
        'message'   => $message,
        'data'      =>  $data
    ];
}


function delete_modal($id, $route, $warning_text = NULL)
{
    $html = '<a href="#delete_' . $id . '" data-bs-toggle="modal" class="btn btn-sm btn-danger waves-effect waves-light mr-1" style="margin-right:10px">' . DELETE_ICON . '</a>';
    $html .= '<div id="delete_' . $id . '" class="modal fade" role="dialog">';
    $html .= '<div class="modal-dialog modal-sm">';
    $html .= '<div class="modal-content">';
    $html .= '<div class="modal-header"><h6 class="modal-title">' . __('Delete') . '</h6><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>';
    $html .= '<div class="modal-body"><p>' . (empty($warning_text) ? __('Would you want to delete ?') : $warning_text) . '</p></div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . __("Close") . '</button>';
    $html .= '<a class="btn btn-danger" href="' . route($route, $id) . '">' . __('Confirm') . '</a>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';
    return $html;
}

function exists($model, $condition, $id = null)
{
    if ($id) {
        return  $model::where($condition)->where('id', '!=', $id)->exists();
    } else {
        return  $model::where($condition)->exists();
    }
}

function parse_contact($contact_no)
{
    $length = strlen($contact_no);
    $new = "";
    if ($length < 11) {
        return 0;
    } else if ($length > 11) {
        $reqLength = $length - 11;

        for ($i = $reqLength; $i < $length; $i++) {
            $new[$i - $reqLength] = $contact_no[$i];
        }
    } else {
        $new = $contact_no;
    }

    return '+88' . $new;
}

/**
 * File upload
 */

function fileUpload($file, $path, $old_file = null)
{
    try {
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }
        $file_name = time() . $file->getClientOriginalName();
        $destinationPath = public_path($path);
        # resize image
        $file->move($destinationPath, $file_name);

        return $path . $file_name;
    } catch (Exception $e) {
        // dd($e);
        return null;
    }
}

// income
function chart()
{
    return [100, 200, 0, 100, 500, 300, 100];
    // $data = array();
    // $date = Carbon::now();

    // #TODO: replaced loop by query

    // for ($i = 0; $i < 7; $i++) {
    //     $income = Transaction::whereDate('date', $date->toDateString())->sum('cash_in');
    //     // $expense = Transaction::where('description', '!=', TRANSACTION_EMPLOYEE_SALARY)->whereDate('date', $date->toDateString())->sum('cash_in');
    //     $data[] = [$income];
    //     $date->subDay();
    // }
    // return successResponse("Earning Report", $data);
}

function money_format($number)
{
    $decimal = (string)($number - floor($number));
    $money = floor($number);
    $length = strlen($money);
    $delimiter = '';
    $money = strrev($money);

    for ($i = 0; $i < $length; $i++) {
        if (($i == 3 || ($i > 3 && ($i - 1) % 2 == 0)) && $i != $length) {
            $delimiter .= ',';
        }
        $delimiter .= $money[$i];
    }

    $result = strrev($delimiter);
    $decimal = preg_replace("/0\./i", ".", $decimal);
    $decimal = substr($decimal, 0, 3);

    // if ($decimal != '0') {
    //     $result = $result . $decimal;
    // }  

    return  $decimal != '0' ? $result . $decimal : $result . '.00';
}
