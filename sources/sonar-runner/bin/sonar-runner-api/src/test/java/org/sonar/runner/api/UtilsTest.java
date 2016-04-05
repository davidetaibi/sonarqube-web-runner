/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.api;

import org.junit.Rule;
import org.junit.rules.TemporaryFolder;

import java.io.Closeable;
import java.io.File;
import java.io.IOException;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Path;
import java.util.Properties;

import org.junit.Test;
import static org.fest.assertions.Assertions.assertThat;
import static org.mockito.Mockito.doThrow;
import static org.mockito.Mockito.mock;
import static org.mockito.Mockito.verify;

public class UtilsTest {
  @Rule
  public TemporaryFolder temp = new TemporaryFolder();

  @Test
  public void should_join_strings() {
    assertThat(Utils.join(new String[] {}, ",")).isEqualTo("");
    assertThat(Utils.join(new String[] {"foo"}, ",")).isEqualTo("foo");
    assertThat(Utils.join(new String[] {"foo", "bar"}, ",")).isEqualTo("foo,bar");
  }

  @Test
  public void task_should_require_project() {
    Properties props = new Properties();
    assertThat(Utils.taskRequiresProject(props)).isTrue();

    props.setProperty("sonar.task", "scan");
    assertThat(Utils.taskRequiresProject(props)).isTrue();
  }

  @Test
  public void write_properties() throws IOException {
    File f = temp.newFile();
    Properties p = new Properties();
    p.put("key", "value");
    Utils.writeProperties(f, p);
    assertThat(Files.readAllLines(f.toPath(), StandardCharsets.UTF_8)).contains("key=value");
  }

  @Test
  public void task_should_not_require_project() {
    Properties props = new Properties();
    props.setProperty("sonar.task", "views");
    assertThat(Utils.taskRequiresProject(props)).isFalse();
  }

  @Test
  public void close_quietly_error() throws IOException {
    Closeable c = mock(Closeable.class);
    doThrow(IOException.class).when(c).close();
    Utils.closeQuietly(c);
    verify(c).close();
  }

  @Test
  public void close_quietly_null() throws IOException {
    Utils.closeQuietly(null);
  }

  @Test
  public void close_quietly() throws IOException {
    Closeable c = mock(Closeable.class);
    Utils.closeQuietly(c);
    verify(c).close();
  }
  
  @Test
  public void delete_quietly() {
    File f = mock(File.class);
    doThrow(IOException.class).when(f).toPath();
    Utils.deleteQuietly(f);
  }

  @Test
  public void delete_non_empty_directory() throws IOException {
    /*-
     * Create test structure:
     * tmp 
     *   |-folder1
     *        |- file1
     *        |- folder2
     *             |- file2
     */
    Path tmpDir = Files.createTempDirectory("junit");
    Path folder1 = tmpDir.resolve("folder1");
    Files.createDirectories(folder1);
    Path file1 = folder1.resolve("file1");
    Files.write(file1, "test1".getBytes());

    Path folder2 = folder1.resolve("folder2");
    Files.createDirectories(folder2);
    Path file2 = folder1.resolve("file2");
    Files.write(file2, "test2".getBytes());

    // delete it
    assertThat(tmpDir.toFile()).exists();
    Utils.deleteQuietly(tmpDir.toFile());
    assertThat(tmpDir.toFile()).doesNotExist();
  }
}
