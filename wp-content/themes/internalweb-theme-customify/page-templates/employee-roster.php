<?php

/*
Template Name: Employee Roster
*/

get_header();

?>

<div class="employee-roster-container">
    <table class="tablesorter">
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Cell Phone</th>
                <th>Extension</th>
                <th>Company</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $all_users = get_users();
            // echo var_dump($all_users);
            foreach ($all_users as $user) :
                if ($user->display_name != 'admin') : ?>
                    <tr>
                        <td style="background-image:url('<?php echo '/wp-content/uploads/' . strtolower(str_replace(array('(', ')', ' '), '', preg_replace('/\([^)]+\)/', '', $user->first_name))) . '-' . strtolower($user->last_name) . '.jpg'; ?>');" <?php if (strtolower(str_replace(array('(', ')', ' '), '', preg_replace('/\([^)]+\)/', '', $user->first_name))) == 'chuck' && strtolower($user->last_name) == 'ceccarelli') : ?>id="roster-chuck-hover"<?php endif; ?>></td>
                        <td><?php echo $user->first_name . ' ' . $user->last_name; ?></td>
                        <td><?php echo str_replace('Iws', 'IWS', ucwords(str_replace('-', ' ', $user->employee_department))); ?></td>
                        <td><a href="mailto:<?php echo $user->user_email; ?>"><?php echo $user->user_email; ?></a></td>
                        <td><a href="tel:<?php echo $user->employee_phone ?>"><?php echo $user->employee_phone; ?></a></td>
                        <td><?php echo $user->employee_extension; ?></td>
                        <td><?php if ($user->employee_company == 'all-companies' || $user->employee_company == 'inventive-group') {
                                echo 'Inventive-Group';
                            } elseif ($user->employee_company == 'iws') {
                                echo 'IWS';
                            } ?></td>
                    </tr>
            <?php
                endif;
            endforeach; ?>
        </tbody>
    </table>
</div>

<?php

get_footer()

?>